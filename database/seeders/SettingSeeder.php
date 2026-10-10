<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Site-wide content & SEO settings. These are always refreshed.
     */
    protected array $content = [
        'site_title'          => 'Dharamshala Travels',
        'site_logo'           => '/images/logo.png',
        'site_favicon'        => '/images/favicon-48.png',
        'seo_business_logo'   => '/images/logo.png',
        'meta_title'          => 'Dharamshala Travels | Taxi Service in Dharamshala, Gaggal Airport Cabs & Himachal Tours',
        'meta_description'    => 'Trusted taxi service in Dharamshala & McLeodganj: Gaggal Airport pickups, local sightseeing, outstation cabs and Himachal tour packages.',
        'meta_keywords'       => 'taxi in dharamshala, dharamshala taxi service, gaggal airport taxi, kangra airport cab, mcleodganj taxi, dharamshala sightseeing, dharamshala to manali taxi, dharamshala to amritsar taxi, himachal tour packages, triund trek package',
        'meta_robots'         => 'index,follow',
        'og_title'            => null,
        'og_description'      => null,
        'og_image'            => '/images/dharamshala/dhauladhar-alpenglow.jpg',
        'twitter_card'        => 'summary_large_image',
        'twitter_title'       => null,
        'twitter_description' => null,
        'twitter_image'       => null,

        'seo_schema_enabled'  => '1',
        'seo_business_name'   => 'Dharamshala Travels',
        'seo_opening_hours'   => 'Mo-Su 06:00-23:00',
                'seo_service_areas'   => 'Dharamshala, McLeodganj, Dharamkot, Bhagsu, Naddi, Kangra, Gaggal Airport, Palampur, Bir Billing, Himachal Pradesh',

        'top_bar_text'        => 'Gaggal Airport (DHM) pickups • Local sightseeing • Outstation cabs across Himachal',
        'top_bar_location'    => 'Dharamshala, Himachal Pradesh',

        'hero_banner_image'   => '/images/dharamshala/dhauladhar-alpenglow.jpg',
        'hero_title'          => 'Explore Dharamshala with Trusted Local Drivers',
        'hero_subtitle'       => 'Gaggal Airport transfers, McLeodganj sightseeing and outstation cabs across Himachal — clean cars and verified hill drivers.',

        'contact_subtitle'        => 'Your local taxi and tour desk in Dharamshala, Himachal Pradesh.',
        'contact_email_response'  => 'Response within 2 hours',
        'contact_guarantee_title' => 'Local Hill Drivers',
        'contact_guarantee_desc'  => 'Experienced drivers who know every road in the Kangra Valley. Quick dispatch for Gaggal Airport transfers and local sightseeing.',
        'footer_description'      => 'Local taxi service, Gaggal Airport transfers and Himachal tour packages from Dharamshala. Travel comfortably with experienced hill drivers who know every bend of the Dhauladhars.',
    ];

    /**
     * Business contact details — only filled when not set yet,
     * so real details entered in the admin panel are never overwritten.
     */
    protected array $defaults = [
        'contact_phone'   => '+91 98765 43210',
        'contact_email'   => 'info@dharamshalatravels.com',
        'contact_address' => 'Main Taxi Stand, Kotwali Bazar, Dharamshala, Himachal Pradesh 176215',
        'contact_hours'   => 'Available 6:00 AM – 11:00 PM',
        'top_bar_phone'   => '+91 98765 43210',
        'seo_latitude'    => '32.2190',
        'seo_longitude'   => '76.3234',
    ];

    public function run(): void
    {
        foreach ($this->content as $key => $value) {
            Setting::set($key, $value);
        }

        foreach ($this->defaults as $key => $value) {
            if (blank(Setting::get($key))) {
                Setting::set($key, $value);
            }
        }
    }
}
