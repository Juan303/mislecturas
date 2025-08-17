<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaJuegos extends Model
{

    protected $fillable = ['juego_id', 'lista_id'];

    public function juegos(){
        return $this->belongsTo(Juego::class);
    }
    public function listas(){
        return $this->belongsTo(Lista::class);
    }


}
