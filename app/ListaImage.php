<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class ListaImage extends BaseImage
{
    protected $fillable = ['lista_id', 'image', 'thumbnail', 'featured', 'name', 'description'];
    protected $folder = 'listas';
    protected $item_pk = 'lista_id';


    protected static function boot()
    {
        parent::boot();
        static::deleting(function (self $image) {
            Storage::disk('public')->delete('images/listas/'.$image->lista->id."/images/".$image->image);
            Storage::disk('public')->delete('images/listas/'.$image->lista->id."/thumbnails/".$image->thumbnail);
        });
    }

    public function lista(){
        return $this->belongsTo(Lista::class);
    }
}
