<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Hotel;

use Illuminate\Foundation\Http\FormRequest;

final class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'require|int',
        ];
    }
}
