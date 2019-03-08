<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Program extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'program_id' => $this->PROGRAM_ID,
            'program_name' => $this->PROGRAM_NAME,
            
        ];
    }
}
