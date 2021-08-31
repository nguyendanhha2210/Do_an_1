<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductImage extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'product_id', 'image_1', 'image_2', 'image_3'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
