<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'title', 'id_category_post','desc','images','status','content','views'
    ];

    public function categoryPost()
    {
        return $this->belongsTo('App\Models\CategoryPost','id_category_post','id');
    }
}
