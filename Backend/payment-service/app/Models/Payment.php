<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'reservation_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => PaymentStatus::class,
    ];

    protected $attributes = [
        'status' => PaymentStatus::PENDING,
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getReservationId(): int
    {
        return $this->reservation_id;
    }

    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }
}
