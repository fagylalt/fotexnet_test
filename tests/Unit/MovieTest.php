<?php

namespace Tests\Unit;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieTest extends TestCase
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
    }

    public function test_it_can_list_all_movies()
    {
        $response = $this->getJson('/api/movies/list');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'description', 'age_limit', 'language', 'cover_art'],
            ]);
    }

    public function test_it_can_create_a_movie()
    {
        $response = $this->postJson('/api/movies/create', [
            'title' => 'New Movie',
            'description' => 'A new movie description',
            'age_limit' => 16,
            'language' => 'English',
            'cover_art' => 'https://via.placeholder.com/200x300.png/00aacc?text=movie+poster',
        ]);

        $response->assertStatus(200)
            ->assertJson(['cover_art' => 'https://via.placeholder.com/200x300.png/00aacc?text=movie+poster']);

        $this->assertDatabaseHas('movies', ['title' => 'New Movie']);
    }

    public function test_it_can_retrieve_a_single_movie()
    {
        $movie = Movie::first();

        $response = $this->getJson("/api/movies/get/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $movie->id,
                'title' => $movie->title,
            ]);
    }

    public function test_it_can_update_a_movie()
    {
        $movie = Movie::first();

        $response = $this->postJson("/api/movies/update/{$movie->id}", [
            'title' => 'Updated Movie Title',
            'description' => 'Updated movie description',
            'age_limit' => 18,
            'language' => 'French',
            'cover_art' => 'https://via.placeholder.com/200x300.png/003355?text=updated+poster',
        ]);

        $response->assertStatus(200)
            ->assertJson(['description' => 'Updated movie description']);

        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'title' => 'Updated Movie Title']);
    }

    public function test_it_can_delete_a_movie()
    {
        $movie = Movie::first();

        $response = $this->deleteJson("/api/movies/delete/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Movie deleted successfully']);

        $this->assertSoftDeleted('movies', ['id' => $movie->id]);
    }
}
