<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesStageResource extends JsonResource
{
    /**
     * リソースをAPIレスポンス用に変換
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sales_stage_code' => $this->sales_stage_code,
            'sales_stage_name' => $this->sales_stage_name,
            'updated_by' => [
                'id' => optional($this->updatedBy)->id,
                'user_name' => optional($this->updatedBy)->user_name,
            ],
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}