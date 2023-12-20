<?php

declare(strict_types=1);

namespace App\Http\Requests\Pagination;

trait PaginationTrait
{
    public function getPaginationRules(): array
    {
        return [
            'page' => 'sometimes|integer|min:0',
            'limit' => 'required|integer|min:1|max:100',
        ];
    }

    public function getLimit(): int
    {
        return $this->integer('offset');
    }

    public function hasPage(): bool
    {
        return $this->has('page');
    }

    public function getPage(): int
    {
        return $this->integer('page');
    }
}
