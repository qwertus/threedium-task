<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     *  @var    string
     *  @access protected
     */
    protected $table = 'article_images';

    /**
     *  Attributes that are mass assignable
     *
     *  @var array
     *  @access protected
     */
    protected $fillable = [
        'feed_id', 'path'
    ];
    
    
}
