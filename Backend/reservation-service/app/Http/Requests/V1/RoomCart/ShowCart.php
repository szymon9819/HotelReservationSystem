<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\RoomCart;

use Illuminate\Foundation\Http\FormRequest;

class ShowCart extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
        ];
    }

    public function getCustomerId(): int
    {
        return $this->integer('customer_id');
    }
}
