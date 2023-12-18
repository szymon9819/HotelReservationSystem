<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Hotel;

use Illuminate\Foundation\Http\FormRequest;

final class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
