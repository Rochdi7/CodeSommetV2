<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
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

    public function test_svg_upload_is_rejected(): void
    {
        $svg = UploadedFile::fake()->createWithContent('x.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>');

        $this->actingAs($this->admin())
            ->postJson('/admin/media/upload', ['file' => $svg])
            ->assertStatus(422);

        $this->assertDatabaseCount('media', 0);
    }

    public function test_php_and_double_extension_files_are_rejected(): void
    {
        $php = UploadedFile::fake()->createWithContent('shell.php', '<?php echo 1;');
        $this->actingAs($this->admin())->postJson('/admin/media/upload', ['file' => $php])->assertStatus(422);

        $double = UploadedFile::fake()->createWithContent('evil.php.jpg', 'not a real image');
        $this->actingAs($this->admin())->postJson('/admin/media/upload', ['file' => $double])->assertStatus(422);

        $this->assertDatabaseCount('media', 0);
    }

    public function test_valid_image_succeeds_with_server_generated_filename(): void
    {
        $img = UploadedFile::fake()->image('My Photo.png', 300, 200);

        $response = $this->actingAs($this->admin())->post('/admin/media/upload', ['file' => $img]);

        $response->assertOk()->assertJson(['success' => true]);
        $medium = Media::first();
        $this->assertNotNull($medium);
        // Filename is server-generated (8-hex + ext), never the client name.
        $this->assertMatchesRegularExpression('#^media/[0-9a-f]{8}\.png$#', $medium->path);
        $this->assertStringNotContainsString('My Photo', $medium->path);
        Storage::disk('public')->assertExists($medium->path);
    }

    public function test_malicious_original_name_is_sanitized(): void
    {
        $img = UploadedFile::fake()->image('"><img src=x onerror=alert(1)>.png', 50, 50);

        $this->actingAs($this->admin())->post('/admin/media/upload', ['file' => $img])->assertOk();

        $medium = Media::first();
        $this->assertStringNotContainsString('<', $medium->original_name);
        $this->assertStringNotContainsString('>', $medium->original_name);
        $this->assertStringNotContainsString('"', $medium->original_name);
    }

    public function test_referenced_media_cannot_be_deleted(): void
    {
        $img = UploadedFile::fake()->image('pic.png', 50, 50);
        $this->actingAs($this->admin())->post('/admin/media/upload', ['file' => $img])->assertOk();
        $medium = Media::first();

        $category = Category::create(['name' => 'News']);
        BlogPost::create([
            'title' => 'Post', 'slug' => 'post', 'content' => 'see <img src="'.$medium->url.'">',
            'category_id' => $category->id, 'status' => 'draft',
        ]);

        $this->actingAs($this->admin())
            ->deleteJson('/admin/media/'.$medium->id)
            ->assertStatus(409);

        $this->assertDatabaseHas('media', ['id' => $medium->id]);
        Storage::disk('public')->assertExists($medium->path);
    }

    public function test_unreferenced_media_can_be_deleted(): void
    {
        $img = UploadedFile::fake()->image('pic.png', 50, 50);
        $this->actingAs($this->admin())->post('/admin/media/upload', ['file' => $img])->assertOk();
        $medium = Media::first();

        $this->actingAs($this->admin())
            ->deleteJson('/admin/media/'.$medium->id)
            ->assertOk();

        $this->assertDatabaseMissing('media', ['id' => $medium->id]);
    }
}
