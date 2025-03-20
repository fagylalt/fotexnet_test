<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'age_limit',
        'language',
        'cover_art'
    ];

    protected $table = "movies";

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
}
