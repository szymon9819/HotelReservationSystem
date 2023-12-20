<?php

declare(strict_types=1);

namespace App\Http\Requests\Pagination;

interface PaginationInterface
{
    public function hasPage(): bool;

    public function getPage(): int;

    public function getLimit(): int;
}
