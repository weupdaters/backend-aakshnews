<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationHelper
{
    /**
     * Format a paginator object into standardized API pagination format.
     */
    public static function format(LengthAwarePaginator $paginator, string $resourceClass = null): array
    {
        $items = $paginator->items();

        if ($resourceClass && class_exists($resourceClass)) {
            $items = $resourceClass::collection($items);
        }

        return [
            'data' => $items,
            'links' => [
                'first' => $paginator->url(1),
                'last'  => $paginator->url($paginator->lastPage()),
                'prev'  => $paginator->previousPageUrl(),
                'next'  => $paginator->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from'         => $paginator->firstItem(),
                'last_page'    => $paginator->lastPage(),
                'path'         => $paginator->path(),
                'per_page'     => $paginator->perPage(),
                'to'           => $paginator->lastItem(),
                'total'        => $paginator->total(),
            ],
        ];
    }
}
