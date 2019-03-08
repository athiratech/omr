<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Notify extends JsonResource
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
            // 'group_id' => $this->GROUP_ID,
            // 'name' => $this->GROUP_NAME,
            'Title'=>$this->title,
            'Url'=>$this->url,
            'Parameter'=>$this->parameter,
            'Notify_type'=>$this->notify_type,
            // 'CreatedDateTime'=>$this->created_at,

            
        ];
    }
}
