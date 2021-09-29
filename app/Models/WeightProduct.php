<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightProduct extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id', 'product_id', 'weight', 'price'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
