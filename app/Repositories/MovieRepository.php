<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Models\Movie;
use Illuminate\Support\Collection;

class MovieRepository implements IRepository
{
    public function all(): Collection
    {
        return Movie::all();
    }

    public function find(int $id): Movie
    {
        return Movie::findOrFail($id);
    }

    public function create(array $data): Movie
    {
        return Movie::create($data);
    }

    public function update($id, array $data): Movie
    {
        $movie = Movie::findOrFail($id);
        $movie->update($data);
        return $movie;
    }

    public function delete($id): bool
    {
        $movie = Movie::findOrFail($id);
        return $movie->delete();

    }
}