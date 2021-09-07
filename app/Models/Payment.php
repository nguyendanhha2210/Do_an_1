<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'order_id', 'totalMoney','note','vnp_response','code_vnpay','code_back','time'
    ];
}
