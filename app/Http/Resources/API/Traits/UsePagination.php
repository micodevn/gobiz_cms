<?php

namespace App\Http\Resources\API\Traits;

trait UsePagination
{
    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages' => $resource->lastPage(),
            'next_page_url' => $resource->nextPageUrl(),
            'previous_page_url' => $resource->previousPageUrl()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }
}
