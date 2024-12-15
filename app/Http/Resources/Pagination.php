<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Pagination extends ResourceCollection
{
    private array $additional_values = [];

    private function getPaginationTemplate($total = 0, $per_page = 15, $current_page = 1, $last_page = 1, $collection = []): array
    {
        $result = [];

        $result['pagination'] = [
            'total' => $total,
            'per_page' => $per_page,
            'current_page' => $current_page,
            'last_page' => $last_page,
        ];

        $result = array_merge($result, $this->additional_values);

        $result['items'] = $collection;

        return $result;
    }

    public function __construct($resource = null, $view = null, $additional_values = [])
    {
        parent::__construct($resource);

        if ($view !== null) {
            $this->collection = $view::collection($resource);
        }

        $this->additional_values = $additional_values;
    }

    public function toArray($request): array
    {
        return $this->getPaginationTemplate(
            $this->total(),
            $this->perPage(),
            $this->currentPage(),
            $this->lastPage(),
            $this->collection
        );
    }
}
