<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Reservation;

use App\Contracts\Reservation\CreateReservationContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

final class CreateRequest extends FormRequest implements CreateReservationContract
{
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function getCustomerId(): int
    {
        return $this->integer('customer_id');
    }

    public function getStartData(): Carbon
    {
        return Carbon::parse($this->input('start_date'));
    }

    public function getEndData(): Carbon
    {
        return Carbon::parse($this->input('end_date'));
    }
}
