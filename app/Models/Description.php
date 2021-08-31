<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Description extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'description'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
