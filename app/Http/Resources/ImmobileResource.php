<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ImmobileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = parent::toArray($request);
        $array = Arr::except($array, 'deleted_at');
        $array += ['status' => $this->statusContract($array['contract'])];

        return $array;
    }

    public function statusContract($contract)
    {
        if ($contract) {
            return [
                'text' => 'CONTRACTED',
                'color' => 'primary',
            ];
        }

        return [
            'text' => 'NON-CONTRACTED',
            'color' => 'default',
        ];
    }
}
