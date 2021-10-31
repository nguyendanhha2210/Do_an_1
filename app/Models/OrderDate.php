<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderDate extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'order_id', 'order_date', 'delivery_date', 'receive_date', 'evaluate_date',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
