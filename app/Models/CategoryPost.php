<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CategoryPost extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'name','desc'
    ];
    
    public function posts()
    {
        return $this->hasMany('App\Models\Post','id_category_post','id');
    }
}
