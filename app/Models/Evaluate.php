<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Evaluate extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'user_id',  'order_code', 'product_id', 'star_vote', 'content', 'rank', 'reply_code', 'image_1', 'image_2', 'image_3', 'image_4'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
