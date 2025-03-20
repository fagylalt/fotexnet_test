<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScreeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createTestData();
    }

    private function createTestData()
    {
        $movie = Movie::factory(10)
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

    public function test_it_can_list_all_screenings()
    {
        $response = $this->getJson('/api/screenings/list');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'date', 'available_seats', 'movie']
            ]);
    }

    public function test_it_can_create_a_screening()
    {
        $movie = Movie::first();

        $response = $this->postJson('/api/screenings/create', [
            'date' => '2025-05-15 19:30:00',
            'available_seats' => 30,
            'movie_id' => $movie->id
        ]);

        $response->assertStatus(200)
            ->assertJson(['date' => '2025-05-15 19:30:00']);

        $this->assertDatabaseHas('screenings', ['movie_id' => $movie->id]);
    }

    public function test_it_can_retrieve_a_single_screening()
    {
        $screening = Screening::first();

        $response = $this->getJson("/api/screenings/get/{$screening->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $screening->id,
                'available_seats' => $screening->available_seats
            ]);
    }

    public function test_it_can_update_a_screening()
    {
        $screening = Screening::first();

        $response = $this->postJson("/api/screenings/update/{$screening->id}", [
            'date' => '2025-05-16 20:00:00',
            'available_seats' => 40
        ]);

        $response->assertStatus(200)
            ->assertJson(['available_seats' => 40]);

        $this->assertDatabaseHas('screenings', [
            'id' => $screening->id,
            'available_seats' => 40
        ]);
    }

    public function test_it_can_delete_a_screening()
    {
        $screening = Screening::first();

        $response = $this->deleteJson("/api/screenings/delete/{$screening->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Screening deleted successfully']);

        $this->assertSoftDeleted('screenings', ['id' => $screening->id]);    }

}
