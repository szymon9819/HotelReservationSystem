<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\RoomCart;

use Illuminate\Foundation\Http\FormRequest;

class RemoveItem extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|integer',
        ];
    }

    public function getCustomerId(): int
    {
        return $this->integer('customer_id');
    }

    public function getRoomId(): int
    {
        return $this->integer('room_id');
    }
}
