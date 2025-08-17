<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reto extends Model
{

    protected $table = 'retos';
    protected $fillable = [
        'user_id',
        'CantidadAnual',
        'CantidadMensual'
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
