<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProductImage extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'product_id', 'url'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
