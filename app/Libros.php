<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Libros extends Model
{

    protected $table = 'libros';
    protected $fillable = [
        'id',
        'titulo',
        'tituloOriginal',
        'sinopsis',
        'datosLibro',
        'completa',
        'puntuacion',
        'user_id',
        'fecha_inicio_lectura',
        'fecha_fin_lectura',
        'paginas_leidas',
        'paginas_totales',
        'estado_lectura'
    ];
    protected $casts = ['datosLibro' => 'array'];
    protected $dates = ['fecha_inicio_lectura', 'fecha_fin_lectura', 'fecha_quiero_leer', 'fecha_compra'];


    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function scopeLeidos($query){
        return $query->where('estado_lectura', 2);
    }
}
