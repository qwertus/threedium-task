<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     *  @var    string
     *  @access protected
     */
    protected $table = 'articles';

    /**
     *  Attributes that are mass assignable
     *
     *  @var array
     *  @access protected
     */
    protected $fillable = [
        'user_id', 'title', 'description', 'published_at', 'cover_photo'
    ];
    
    public function images() {
        return $this->hasMany(Image::class , 'article_id' , 'id'); 
    }
    
}
