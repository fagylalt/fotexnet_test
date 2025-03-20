<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screening extends Model
{
    /** @use HasFactory<\Database\Factories\ScreeningFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'available_seats',
        'movie_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'movie_id',
    ];

    protected $table = 'screenings';

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
