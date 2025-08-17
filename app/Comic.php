<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $fillable = ['numero','numeroUnico','precio','moneda','fecha', 'numeroPaginasBN', 'numeroPaginasColor', 'imagen', 'tipo', 'coleccion_id', 'autor'];
    protected $casts = ['dColeccion', 'array'];

    public function coleccion(){
        return $this->belongsTo(Coleccion::class);
    }

    public function usuarioComics(){
        return $this->belongsToMany(UsuarioComic::class);
    }

    public function usuarioLecturas(){
        return $this->hasMany(UsuarioLectura::class);
    }

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }

    public function scopeEditados($query){
        return $query->where('tipo', '=', 'editado');
    }

    public function make_image_url($coleccion_id){
        if($this->imagen == NULL){
            return 'storage/images/default/default.jpg';
        }
        return 'storage/images/'.$coleccion_id.'/'.$this->imagen;
    }
}
