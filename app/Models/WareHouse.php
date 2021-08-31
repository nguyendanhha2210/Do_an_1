<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WareHouse extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'name', 'images', 'import_price', 'import_quantity','inventory','import_date','status'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product','ware_houses_id','id');
    }
}
