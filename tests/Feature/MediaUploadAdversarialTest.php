<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Adversarial upload verification: confirms the GD re-encode strips appended
 * executable content and EXIF, rejects non-images, and sanitizes hostile
 * filenames.
 */
class MediaUploadAdversarialTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_super_admin' => true]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_appended_php_in_valid_image_is_stripped_by_reencode(): void
    {
        // Build a real PNG then append PHP after IEND — a JPEG/PHP polyglot.
        $tmp = tempnam(sys_get_temp_dir(), 'poly') . '.png';
        $img = imagecreatetruecolor(20, 20);
        imagepng($img, $tmp);
        imagedestroy($img);
        file_put_contents($tmp, "\n<?php system(\$_GET['c']); ?>", FILE_APPEND);

        $upload = new UploadedFile($tmp, 'polyglot.png', 'image/png', null, true);

        $this->actingAs($this->admin())
            ->post('/admin/media/upload', ['file' => $upload])
            ->assertOk();

        $medium = Media::first();
        $stored = Storage::disk('public')->get($medium->path);

        // The re-encoded image must NOT contain the PHP payload.
        $this->assertStringNotContainsString('<?php', $stored);
        $this->assertStringNotContainsString('system(', $stored);
        // And it must still be a valid image.
        $info = @getimagesizefromstring($stored);
        $this->assertNotFalse($info, 'Re-encoded output is not a valid image');
        $this->assertSame('image/png', $info['mime']);
    }

    public function test_exif_is_stripped_on_reencode(): void
    {
        // A JPEG with an EXIF comment; after re-encode the comment must be gone.
        $tmp = tempnam(sys_get_temp_dir(), 'exif') . '.jpg';
        $img = imagecreatetruecolor(30, 30);
        imagejpeg($img, $tmp);
        imagedestroy($img);
        // Inject a recognizable marker into the raw bytes.
        $raw = file_get_contents($tmp);
        $raw = str_replace("\xFF\xDA", "SECRETGPS\xFF\xDA", $raw, $count);
        if ($count) {
            file_put_contents($tmp, $raw);
        }

        $upload = new UploadedFile($tmp, 'photo.jpg', 'image/jpeg', null, true);
        $this->actingAs($this->admin())->post('/admin/media/upload', ['file' => $upload])->assertOk();

        $stored = Storage::disk('public')->get(Media::first()->path);
        $this->assertStringNotContainsString('SECRETGPS', $stored);
    }

    public function test_corrupted_image_header_is_rejected(): void
    {
        $bad = UploadedFile::fake()->createWithContent('broken.png', "\x89PNG\r\n\x1a\nCORRUPTGARBAGE");
        $this->actingAs($this->admin())
            ->postJson('/admin/media/upload', ['file' => $bad])
            ->assertStatus(422);
        $this->assertDatabaseCount('media', 0);
    }

    public function test_oversized_dimensions_are_rejected(): void
    {
        // dimensions rule caps at 6000x6000; 7000x100 must fail.
        $big = UploadedFile::fake()->image('huge.png', 7000, 100);
        $this->actingAs($this->admin())
            ->postJson('/admin/media/upload', ['file' => $big])
            ->assertStatus(422);
    }

    public function test_unicode_and_control_char_filename_is_sanitized(): void
    {
        $img = UploadedFile::fake()->image("../\u{202E}evil\x00\"><b>.png", 40, 40);
        $this->actingAs($this->admin())->post('/admin/media/upload', ['file' => $img])->assertOk();

        $medium = Media::first();
        // Stored path is server-generated (8 hex + ext), never the client name.
        $this->assertMatchesRegularExpression('#^media/[0-9a-f]{8}\.png$#', $medium->path);
        // Display name is sanitized: no path, control chars, or HTML.
        $this->assertStringNotContainsString('..', $medium->original_name);
        $this->assertStringNotContainsString('<', $medium->original_name);
        $this->assertStringNotContainsString("\x00", $medium->original_name);
    }

    public function test_html_and_phtml_and_svg_extensions_rejected(): void
    {
        foreach (['x.svg' => '<svg/>', 'x.phtml' => '<?php ?>', 'x.html' => '<html>', 'x.js' => 'alert(1)'] as $name => $content) {
            Storage::fake('public');
            $f = UploadedFile::fake()->createWithContent($name, $content);
            $this->actingAs($this->admin())
                ->postJson('/admin/media/upload', ['file' => $f])
                ->assertStatus(422);
        }
    }
}
