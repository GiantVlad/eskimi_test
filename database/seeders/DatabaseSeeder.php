<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Campaign;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $campaigns = Campaign::factory(50)->create();
        $campaign = $campaigns->first();
        Banner::factory()->create([
            'image_name' => 'image_1.jpeg',
            'campaign_id' => $campaign->id,
        ]);
        Banner::factory()->create([
            'image_name' => 'image_2.png',
            'campaign_id' => $campaign->id,
        ]);
        Banner::factory()->create([
            'image_name' => 'image_3.png',
            'campaign_id' => $campaign->id,
        ]);
    }
}
