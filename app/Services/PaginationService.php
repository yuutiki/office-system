<?php

namespace App\Services;

use Illuminate\Http\Request;

class PaginationService
{
    private const ALLOWED_PER_PAGE = [20, 100, 300, 500];
    private const DEFAULT_PER_PAGE = 100;

    public function getPerPage(Request $request): int
    {
        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);

        return in_array($perPage, self::ALLOWED_PER_PAGE, true) 
            ? $perPage 
            : self::DEFAULT_PER_PAGE;
    }
}
