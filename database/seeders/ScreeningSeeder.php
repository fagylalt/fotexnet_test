<?php

namespace Database\Seeders;

use App\Models\Screening;
use Illuminate\Database\Seeder;

class ScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Screening::factory(10)
            ->state(function () {
                return [
                    'date' => fake()->dateTime(),
                    'available_seats' => fake()->numberBetween(15, 31),
                    'movie_id' => fake()->numberBetween(1, 10),
                ];
            })
            ->create();

    }
}
