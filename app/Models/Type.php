<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Type extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'type'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
