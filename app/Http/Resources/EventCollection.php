<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => url()->current(),
                'next' => $this->nextPageUrl(),
                'prev' => $this->previousPageUrl()
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage()
            ]
        ];
    }
}