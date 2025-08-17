<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioColeccion extends Model
{
    protected $fillable = ['coleccion_id', 'user_id', 'tengo'];
    protected $table = 'usuario_colecciones';

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function coleccion(){
        return $this->belongsTo(Coleccion::class);
    }

    public function usuarioComics(){
        return $this->hasMany(UsuarioComic::class);
    }

    public function usuarioLecturas(){
        return $this->hasMany(UsuarioLectura::class);
    }

    public function comicsLeidosColeccion(){
        return $this->usuarioComics()->with('usuarioLectura')->whereHas('usuarioLectura', function($query){
            $query->whereNotNull('fecha_fin_lectura');
        });
    }

    public function tieneComics(){
        if($this->usuarioComics()->exists()){
            return true;
        }
        return false;
    }

}
