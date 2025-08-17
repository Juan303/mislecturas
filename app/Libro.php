<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Libro extends Model
{

    protected $table = 'libros';
    protected $fillable = [
        'id',
        'titulo',
        'titulo_original',
        'sinopsis',
        'datosLibro',
        'puntuacion',
        'user_id',
        'fecha_inicio_lectura',
        'fecha_fin_lectura',
        'fecha_quiero_leer',
        'paginas_leidas',
        'paginas_totales',
        'estado_lectura',
        'imagen',
        'tengo',
        'autor',
        'editorial',
        'isbn13',
        'fecha_compra',
        'precio_compra'
    ];
    protected $casts = ['datosLibro' => 'array'];
    protected $dates = ['fecha_inicio_lectura', 'fecha_fin_lectura', 'fecha_quiero_leer', 'fecha_compra'];

    //Borrar la imagen cuando se borre el libro
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($libro) {
            \Storage::deleteDirectory('images/libros/' . $libro->id);
        });
    }

    public function usuario(){
        return $this->belongsTo(User::class);
    }



}
