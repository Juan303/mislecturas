<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseImage extends Model
{

    protected $folder = '';
    protected $item_pk = '';
    protected $item = '';

    public function destacar($juego_id){
        $this->where($this->item_pk, $juego_id)->update([
            'featured' => false,
        ]);
        $this->featured = true;
        $this->save();
    }


    public function make_url($item_id){
        if($this->image == NULL){
            return 'storage/images/default/default.jpg';
        }
        return 'storage/images/'.$this->folder.'/'.$item_id.'/images/'.$this->image;
    }

    public function make_thumbnail_url($item_id){
        if($this->image == NULL){
            return 'storage/images/default/default.jpg';
        }
        return 'storage/images/'.$this->folder.'/'.$item_id.'/thumbnails/'.$this->thumbnail;
    }
}
