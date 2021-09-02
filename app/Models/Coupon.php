<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Coupon extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'name', 'time', 'condition', 'status', 'number', 'code', 'start_date', 'end_date'
    ];

    public function userCoupons()
    {
        return $this->hasMany('App\Models\UserCoupon', 'coupon_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_coupons', 'user_id', 'coupon_id');
    }
}
