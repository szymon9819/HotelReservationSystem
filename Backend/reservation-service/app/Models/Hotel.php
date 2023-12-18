<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'description'];

    public function getId(): int
    {
        return $this->id;
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
