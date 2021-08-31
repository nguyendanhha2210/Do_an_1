<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Coupon extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'name', 'time', 'condition', 'number', 'code'
    ];
}
