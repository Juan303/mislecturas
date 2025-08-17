<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UsuarioComic;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class UsuarioLectura extends Model
{
    protected $fillable = ['paginas_totales','paginas_leidas', 'comic_id', 'user_id', 'fecha_inicio_lectura', 'fecha_fin_lectura', 'estado_lectura', 'fecha_quiero_leer'];
    protected $dates = ['fecha_inicio_lectura', 'fecha_fin_lectura', 'fecha_quiero_leer'];
    protected $casts = ['datos'=>'array'];
    protected $table = 'usuario_lecturas';


    public function usuarioComic(){
        return $this->leftjoin('usuario_comics', 'usuario_comic.comic_id', '=', $this->comic_id)->where($this->user_id, auth()->user()->id);
        //return UsuarioComic::where('user_id', auth()->user()->id)->where('comic_id', $idComic)->first();
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function tengo($flag = true){
        $idComic = $this->comic_id;
        $UsuarioComic = auth()->user()->usuarioComics()->where('comic_id', $idComic)->first();
        if($UsuarioComic){
            return $UsuarioComic;
        }
        return [];
    }

    public function scopeLeidos($query){
        return $query->whereNotNull('fecha_fin_lectura');
    }
    public function scopeLeyendo($query){
        return $query->whereNull('fecha_fin_lectura')->whereNotNull('fecha_inicio_lectura');
    }

    public function scopeQuieroLeer($query){
        return $query->whereNull('fecha_fin_lectura')->whereNull('fecha_inicio_lectura');
    }}
