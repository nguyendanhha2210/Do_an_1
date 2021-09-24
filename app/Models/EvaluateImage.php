<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EvaluateImage extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id', 'evaluate_id', 'url'
    ];

    public function evaluate()
    {
        return $this->belongsTo('App\Models\Evaluate','evaluate_id','id');
    }
}
