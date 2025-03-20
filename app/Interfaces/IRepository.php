<?php

namespace App\Interfaces;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface IRepository
{
    public function all(): Collection;
    public function find(int $id): Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): Model;
    public function delete(int $id): bool;
}