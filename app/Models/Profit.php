<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Profit extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'order_code', 'product_id', 'number_product', 'price', 'revenue','import_price', 'cost', 'profit','date'
    ];
}
