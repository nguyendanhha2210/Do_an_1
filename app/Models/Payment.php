<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'order_id','customer_id', 'total_money','vnp_response','code_vnpay','code_back','time'
    ];
}
