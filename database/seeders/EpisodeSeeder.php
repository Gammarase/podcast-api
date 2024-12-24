<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\Guest;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class EpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $episodes = Episode::factory()->count(15)->create();
        foreach ($episodes as $episode) {
            $guests = Guest::inRandomOrder()->limit(3)->pluck('id');
            $topics = Topic::inRandomOrder()->limit(3)->pluck('id');
            $episode->guests()->attach($guests);
            $episode->topics()->attach($topics);
        }
    }
}
