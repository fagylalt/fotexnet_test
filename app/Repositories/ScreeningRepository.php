<?php

namespace App\Repositories;

use App\Interfaces\IRepository;
use App\Models\Screening;
use Illuminate\Support\Collection;

class ScreeningRepository implements IRepository
{
    public function all(): Collection
    {
        return Screening::with('movie')->get();
    }

    public function find(int $id): Screening
    {
        return Screening::with('movie')->findOrFail($id);
    }

    public function create(array $data): Screening
    {
        $screening = Screening::create($data);

        return $screening->load('movie');
    }

    public function update(int $id, array $data): Screening
    {
        $screening = Screening::findOrFail($id);
        $screening->update($data);

        return Screening::with('movie')->findOrFail($id);
    }

    public function delete(int $id): bool
    {
        $screening = Screening::findOrFail($id);

        return $screening->delete();
    }
}
