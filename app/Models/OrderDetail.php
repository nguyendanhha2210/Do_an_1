<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderDetail extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'order_code',  'product_id',  'product_name', 'product_price','order_weight','product_sales_quantity','product_coupon','status_vote'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
