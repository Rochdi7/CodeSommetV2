<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * One execution of an SEO tool through the run API.
 *
 * State machine: pending → running → completed | failed. Transitions out of
 * `pending` are claimed atomically (see claim()), so a retried or duplicated
 * job can never execute a run twice.
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $user_id
 * @property string $tool
 * @property string $mode
 * @property array $input
 * @property string $status
 * @property int|null $progress
 * @property string|null $stage
 * @property array|null $result
 * @property array|null $error
 * @property string $access_token_hash
 * @property int $attempts
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 */
class AnalysisRun extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_RUNNING = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    public const MODE_SYNC = 'sync';
    public const MODE_QUEUED = 'queued';

    protected $fillable = [
        'uuid', 'user_id', 'tool', 'mode', 'input', 'status', 'progress', 'stage',
        'result', 'error', 'access_token_hash', 'attempts', 'started_at', 'completed_at', 'expires_at',
    ];

    protected $hidden = ['id', 'access_token_hash', 'user_id', 'input'];

    protected function casts(): array
    {
        return [
            'input' => 'array',
            'result' => 'array',
            'error' => 'array',
            'progress' => 'integer',
            'attempts' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Create a run and return it with its plain access token. The token is
     * shown to the creator once; only its hash is stored.
     *
     * @param  array<string, mixed>  $input
     * @return array{0: self, 1: string}
     */
    public static function open(string $tool, string $mode, array $input, ?int $userId, \DateTimeInterface $expiresAt): array
    {
        $token = Str::random(48);

        $run = self::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $userId,
            'tool' => $tool,
            'mode' => $mode,
            'input' => $input,
            'status' => self::STATUS_PENDING,
            'access_token_hash' => self::hashToken($token),
            'expires_at' => $expiresAt,
        ]);

        return [$run, $token];
    }

    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    public function tokenMatches(?string $token): bool
    {
        return is_string($token) && $token !== ''
            && hash_equals($this->access_token_hash, self::hashToken($token));
    }

    public function isFinished(): bool
    {
        return in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_FAILED], true);
    }

    /**
     * Atomically move pending → running. Returns false when another worker
     * (or a retry) already claimed or finished the run.
     */
    public function claim(): bool
    {
        $now = now();

        $claimed = self::query()
            ->whereKey($this->getKey())
            ->where('status', self::STATUS_PENDING)
            ->update([
                'status' => self::STATUS_RUNNING,
                'started_at' => $now,
                'attempts' => DB::raw('attempts + 1'),
                'updated_at' => $now,
            ]) === 1;

        $this->refresh();

        return $claimed;
    }

    /**
     * Record honest progress reported by the tool. Never called with
     * invented values: tools that cannot measure progress leave it null.
     */
    public function reportProgress(?int $percent, ?string $stage): void
    {
        $this->forceFill([
            'progress' => $percent === null ? null : max(0, min(100, $percent)),
            'stage' => $stage === null ? null : Str::limit($stage, 117),
        ])->save();
    }

    /**
     * @param  array<string, mixed>  $result
     */
    public function markCompleted(array $result): void
    {
        // Only a running run can complete (guards against a late duplicate).
        self::query()->whereKey($this->getKey())->where('status', self::STATUS_RUNNING)->update([
            'status' => self::STATUS_COMPLETED,
            'result' => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR),
            'progress' => $this->progress === null ? null : 100,
            'stage' => null,
            'completed_at' => now(),
            'updated_at' => now(),
        ]);

        $this->refresh();
    }

    public function markFailed(string $code, string $message): void
    {
        self::query()->whereKey($this->getKey())
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_RUNNING])
            ->update([
                'status' => self::STATUS_FAILED,
                'error' => json_encode(['code' => $code, 'message' => $message], JSON_UNESCAPED_UNICODE),
                'stage' => null,
                'completed_at' => now(),
                'updated_at' => now(),
            ]);

        $this->refresh();
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereNotNull('expires_at')->where('expires_at', '<', now());
    }
}
