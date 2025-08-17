<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioComic extends Model
{
    protected $fillable = ['usuario_coleccion_id', 'user_id', 'comic_id', 'tengo', 'estado_lectura', 'quiero', 'fecha_inicio_lectura', 'fecha_fin_lectura', 'fechaCompra'];
    protected $casts = ['datos'=>'array'];
    protected $table = 'usuario_comics';

    public const ESTADO_NO_LEIDO = 0;
    public const ESTADO_LEYENDO = 1;
    public const ESTADO_LEIDO = 2;
    public const ESTADO_QUIERO_LEER = 3;

    public function usuarioColeccion(){
        return $this->belongsTo(UsuarioColeccion::class);
    }

    public function usuarioLectura(){
        return $this->hasOne(UsuarioLectura::class, 'comic_id', 'comic_id')->where('user_id', auth()->user()->id);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function scopeTengo($query, $flag){
        return $query->where('tengo', $flag);
    }


}
