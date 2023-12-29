<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReservationDateFormat;
use App\Enums\ReservationStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'room_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => ReservationStatus::class,
    ];

    protected $attributes = [
        'status' => ReservationStatus::ACTIVE,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $startDate) => Carbon::parse($startDate)->format(ReservationDateFormat::DEFAULT_FORMAT),
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $endDate) => Carbon::parse($endDate)->format(ReservationDateFormat::DEFAULT_FORMAT),
        );
    }

    public function getNumberOfDaysAttribute(): int
    {
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);

        return $startDate->diffInDays($endDate);
    }

    public function getId(): int
    {
        return $this->id;
    }
}
