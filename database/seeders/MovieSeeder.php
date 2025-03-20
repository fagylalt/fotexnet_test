<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Movie::factory(10)
            ->state(function () {
                return [
                    'title' => fake()->sentence(3),
                    'description' => fake()->paragraph(3),
                    'age_limit' => fake()->numberBetween(10, 18),
                    'language' => fake()->randomElement(['Hungarian', 'English', 'Spanish', 'French', 'Korean', 'Japanese']),
                    'cover_art' => fake()->imageUrl(200, 300, 'movies', true, 'poster'),
                ];
            })
            ->create();
    }
}
