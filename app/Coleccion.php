<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Coleccion extends Model
{

    protected $table = 'colecciones';
    protected $fillable = ['id','titulo', 'tituloOriginal', 'sinopsis', 'datosColeccion', 'numero_comics_editados', 'completa', 'autor'];
    protected $casts = ['datosColeccion' => 'array'];


    public function usuarioColecciones(){
        return $this->hasMany(UsuarioColeccion::class);
    }

    public function comics(){
        return $this->hasMany(Comic::class);
    }

    public function comicsEditados(){
        return $this->hasMany(Comic::class)->where('tipo', 'editado');
    }
    public function comicsPreparacion(){
        return $this->hasMany(Comic::class)->where('tipo', 'preparacion');
    }
    public function comicsNoEditados(){
        return $this->hasMany(Comic::class)->where('tipo', 'no_editado');
    }
    public function comicsLeidos(){

    }
}
