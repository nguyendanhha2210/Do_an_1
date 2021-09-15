<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Evaluate extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'user_id',  'order_id',  'star_vote', 'content', 'image_1', 'image_2', 'image_3', 'image_4'
    ];
}
