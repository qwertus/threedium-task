<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = [];
        $thumbs = [];

        foreach ($this->images()->get() as $image){

            $images[] = $image->path;
            $thumbs[] = $image->thumb;

        }

        $thisFeed['id'] =  $this->id;
        $thisFeed['user_id'] =  $this->user_id;
        $thisFeed['title'] =  $this->title;
        $thisFeed['description'] =  $this->description;
        $thisFeed['cover_photo'] =  $this->cover_photo;
        $thisFeed['images'] =  $images;
        $thisFeed['thumbs'] =  $thumbs;
        
        return $thisFeed;
    }
}
