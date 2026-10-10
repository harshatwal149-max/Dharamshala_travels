<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_save_without_length_or_format_restrictions(): void
    {
        $description = str_repeat('Trusted taxi service in Dharamshala. ', 10);

        $this->actingAs(User::factory()->create())
            ->post(route('admin.settings.update'), [
                'meta_description' => $description,
                'meta_robots'      => 'index,follow',
                'og_image'         => '/images/dharamshala/dhauladhar-alpenglow.jpg',
                'site_email'       => 'info@dharamshalatravels.com',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame(trim($description), Setting::get('meta_description'));
        $this->assertSame('index,follow', Setting::get('meta_robots'));
    }

    public function test_logo_and_favicon_accept_svg_webp_and_ico(): void
    {
        Storage::fake('public');

        $svg = UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><circle cx="5" cy="5" r="4"/></svg>');
        $ico = UploadedFile::fake()->createWithContent('favicon.ico', str_repeat("\0", 64));

        $this->actingAs(User::factory()->create())
            ->post(route('admin.logo-favicon.update'), ['logo_file' => $svg, 'favicon_file' => $ico])
            ->assertSessionHasNoErrors();

        $this->assertStringEndsWith('.svg', Setting::get('site_logo'));
        $this->assertStringStartsWith('/storage/branding/', Setting::get('site_logo'));
        $this->assertStringEndsWith('.ico', Setting::get('site_favicon'));
        Storage::disk('public')->assertExists(str_replace('/storage/', '', Setting::get('site_logo')));

        $webp = UploadedFile::fake()->createWithContent('logo.webp', 'RIFF' . pack('V', 26) . 'WEBPVP8 ' . str_repeat("\0", 18));

        $this->actingAs(User::factory()->create())
            ->post(route('admin.logo-favicon.update'), ['logo_file' => $webp, 'site_logo' => '/images/logo.png'])
            ->assertSessionHasNoErrors();

        $this->assertStringEndsWith('.webp', Setting::get('site_logo'));
    }

    public function test_logo_upload_rejects_non_image_files(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.logo-favicon.update'), [
                'logo_file' => UploadedFile::fake()->createWithContent('shell.php', '<?php echo 1;'),
            ])
            ->assertSessionHasErrors('logo_file');
    }
}
