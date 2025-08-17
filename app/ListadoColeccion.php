<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListadoColeccion extends Model
{

    protected $table = 'listado_colecciones';
    protected $fillable = ['nombre', 'coleccion_id', 'inicial'];
    public $timestamps = false;

    //relaciones
    public function coleccion(){
        return $this->hasOne(Coleccion::class, 'id', 'coleccion_id');
    }

    public function usuarioColeccion(){
        //Puede tener una o ninguna coleccion
        return $this->hasOne(UsuarioColeccion::class, 'coleccion_id', 'coleccion_id');
    }
}
