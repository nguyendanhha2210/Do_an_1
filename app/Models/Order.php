<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'customer_id',  'shipping_id',  'order_code', 'order_status', 'order_date', 'order_destroy', 'total_bill'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function shipping()
    {
        return $this->belongsTo('App\Models\Shipping');
    }
}
