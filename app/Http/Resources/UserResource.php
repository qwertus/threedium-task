<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $thisFeed['id'] =  $this->id;
        $thisFeed['name'] =  $this->name;
        $thisFeed['email'] =  $this->email;
        $thisFeed['api_token'] =  $this->api_token;
        
        return $thisFeed;
    }
}
