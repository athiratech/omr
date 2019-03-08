<?php


namespace App\Http\Resources;
use App\Mode;
use App\Modesyear;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Http\Request;
class Employee extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'ID' => $this->test_code,
        ];
    }
}
