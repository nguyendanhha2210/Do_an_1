<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weight extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = [
        'id', 'weight'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
