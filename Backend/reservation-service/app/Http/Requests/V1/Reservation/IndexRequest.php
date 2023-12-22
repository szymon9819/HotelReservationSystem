<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Reservation;

use App\Contracts\Reservation\GetReservationsContract;
use App\Enums\ReservationStatus;
use App\Http\Requests\Pagination\BasePaginationRequest;

class IndexRequest extends BasePaginationRequest implements GetReservationsContract
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'customer_id' => 'required|integer',
            'start_date' => 'required_with:end_date|nullable|date',
            'end_date' => 'required_with:start_date|nullable|date|after:start_date',

            'status' => 'nullable|string',
        ];
    }

    public function getCustomerId(): int
    {
        return $this->integer('customer_id');
    }

    public function getStartDate(): string
    {
        return $this->input('start_date');
    }

    public function getEndDate(): string
    {
        return $this->input('end_date');
    }

    public function hasStartDate(): bool
    {
        return $this->has('start_date');
    }

    public function hasEndDate(): bool
    {
        return $this->has('end_date');
    }

    public function hasStatus(): bool
    {
        return $this->has('status');
    }

    public function getStatus(): ReservationStatus
    {
        return ReservationStatus::from($this->input('status'));
    }
}
