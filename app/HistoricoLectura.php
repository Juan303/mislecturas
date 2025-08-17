<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoLectura extends Model
{
    protected $fillable = [
        'user_id',
        'comic_id',
        'libro_id',
        'PaginasLeidas',
        'created_at',
        'updated_at'
    ];


    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function libro(){
        return $this->belongsTo(Libro::class);
    }


}
