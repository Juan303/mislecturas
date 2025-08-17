<?php

namespace App;

use Carbon\Carbon;
use igaster\TranslateEloquent\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Prestamo extends Model
{

    protected $fillable = ['item_id','usuario_id','persona', 'direccion', 'tipo'];
    protected $table = 'prestamos';

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }
}
