<?php

declare(strict_types=1);

namespace App\Http\Requests\Pagination;

use Illuminate\Foundation\Http\FormRequest;

abstract class BasePaginationRequest extends FormRequest implements PaginationInterface
{
    use PaginationTrait;

    public function rules(): array
    {
        return $this->getPaginationRules();
    }
}
