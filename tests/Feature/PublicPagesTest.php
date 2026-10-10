<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\TaxiRoute;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public static function pages(): array
    {
        return array_map(fn ($uri) => [$uri], [
            '/',
            '/destinations',
            '/destinations/triund-trek',
            '/taxi-routes',
            '/taxi-routes/dharamshala-to-manali-taxi',
            '/gaggal-airport-taxi',
            '/about',
            '/photo-credits',
            '/tours',
            '/cabs',
            '/cabs/toyota-innova-crysta',
            '/contact',
            '/blogs',
            '/blogs/triund-trek-guide',
        ]);
    }

    #[DataProvider('pages')]
    public function test_public_page_renders(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public function test_pages_use_page_level_seo_and_structured_data(): void
    {
        $this->get('/destinations/triund-trek')
            ->assertSee('<title>Triund — Travel Guide, Timings &amp; Taxi | Dharamshala Travels</title>', false)
            ->assertSee('"@type":"TouristAttraction"', false)
            ->assertSee('"@type":"BreadcrumbList"', false);

        $this->get('/')->assertSee('"@type":"FAQPage"', false);
    }

    public function test_seeders_are_idempotent(): void
    {
        $counts = [Destination::count(), TaxiRoute::count()];

        $this->seed(DatabaseSeeder::class);

        $this->assertSame($counts, [Destination::count(), TaxiRoute::count()]);
    }

    public function test_sitemap_lists_new_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false)
            ->assertSee(route('destinations.show', 'mcleodganj'))
            ->assertSee(route('taxi-routes.show', 'gaggal-airport-to-mcleodganj-taxi'));
    }
}
