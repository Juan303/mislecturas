<?php

namespace App;

use Carbon\Carbon;
use igaster\TranslateEloquent\TranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lista extends Model
{

    protected $fillable = ['estado','publica','estadisticas', 'nombre', 'descripcion', 'user_id', 'image', 'publicated_at'];

    //protected $dates = ['publicated_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Lista $lista) {
            Storage::disk('public')->deleteDirectory('images/listas/'.$lista->id);
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function images(){
        return $this->hasMany(ListaImage::class);
    }
    public function juegos(){
        return $this->belongsToMany(Juego::class);
    }

    public function getPublishedLists(){
        return $this->where('publicated_at', '<=', new Carbon())->get();
    }

    public function make_featured_image_url($lista_id){
        if (count($this->images) > 0) {
            $image = $this->images->where('featured', true)->first();
            return 'storage/images/listas/'.$lista_id.'/images/'.$image->image;
        }
        return 'storage/images/default/default.jpg';
    }
    public function make_featured_thumbnail_image_url($lista_id){
        if (count($this->images) > 0) {
            $image = $this->images->where('featured', true)->first();
            return 'storage/images/listas/'.$lista_id.'/thumbnails/'.$image->thumbnail;
        }
        return 'storage/images/default/default.jpg';
    }

    public function hasJuego($juego_id){
       $juegos = $this->juegos()->find($juego_id);
       if(count($juegos)>0){
           return true;
       }
       return false;
    }

    public function getImageDirAttribute(){
        return $this->id;
    }

    //SCOPES
    public function scopeActive($query, $flag){
        return $query->where('active', $flag);
    }

}
