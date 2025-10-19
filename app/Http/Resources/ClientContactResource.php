<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => trim($this->last_name . ' ' . $this->first_name),
            'department' => $this->division_name,
            'position' => $this->position_name,
        ];
    }
}
