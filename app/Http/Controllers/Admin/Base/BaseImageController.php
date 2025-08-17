<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class BaseImageController extends Controller
{
    public $item = '';
    public $imageItem = '';
    public $tamanyoImagenes = [];
    public $ruta_volver = "";
    public $processType = "";
    public $admin = "";

    public function index($item_id){

        $classname = strtolower(class_basename($this->item));
        $item = $this->item->find($item_id);
        $item->load([
            'images' => function($q){
                $q->orderBy('featured', 'DESC');
            }
        ])->get();
        $datos['titulo'] = 'Imagenes para: '.$item->nombre;
        $datos['ruta_store'] = route ($this->admin.$classname.'_images.store', [$classname=>$item->id]);
        $datos['items'] = $item->images;
        $datos['modal_delete_message'] =  '¿Seguro que quiere eliminar la imagen?';
        $datos['ruta_volver'] =  route($this->ruta_volver);
        if($this->ruta_volver === 'welcome'){
            $datos['ruta_volver'] =  route ($this->ruta_volver);
        }
        return view($this->admin.$classname.'s.images.index')->with([$classname => $item])->with($datos);
    }

    public function store(Request $request, $item_id){

        $classname = strtolower(class_basename($this->item));
        $item = $this->item->find($item_id);

        $success = true;
        $files = $request->file('file');


        foreach($files as $file) {
            $fileName = uniqid()."_".$item->nombre;
            //$fileName = uniqid()."_".$file->getClientOriginalName();
            $thumb_fileName = 'thumb_'.$fileName;
            if ($imagePath = $file->storeAs('images/'.$classname.'s/'.$item->id.'/images', $fileName)) {
                try {
                    $intervention = new ImageManager(['driver' => 'gd']);
                    $image_thumb = $intervention->make(Storage::get($imagePath))->{$this->processType}($this->tamanyoImagenes['ancho'], $this->tamanyoImagenes['alto'], function($constraint){
                        $constraint->aspectRatio();
                    })->encode();
                    Storage::disk('public')->put('images/'.$classname.'s/'.$item->id.'/thumbnails/' . $thumb_fileName, $image_thumb);
                    //Storage::disk('public')->delete('images/' . $fileName);
                    DB::beginTransaction();
                    //apaño
                    $fk = (strtolower(class_basename($this->item)).'_id' === 'bdsistema_id')?'bd_sistema_id':strtolower(class_basename($this->item)).'_id';
                    $new_image = $this->imageItem->create([
                        'image' => $fileName,
                        'thumbnail' => $thumb_fileName,
                        $fk => $item->id
                    ]);
                    if (count($item->images) <= 1) {
                        $this->feature($item->id, $new_image->id);
                    }
                } catch (\Exception $exception) {
                    dd($exception->getMessage());
                    $success = $exception->getMessage();
                    DB::rollBack();
                }
                if ($success === true) {

                    DB::commit();
                    session()->flash('message', ['type' => 'success', 'text'=>'imagen registrada correctamente'.$item->image_dir]);
                    /* $response = [
                         'type' => 'success',
                         'text' => 'imagenes registradas correctamente'
                     ];*/
                } else {
                    dd("fallo");
                    session()->flash('message', ['type' => 'danger', 'text'=>$success]);
                    /* $response = [
                         'type' => 'danger',
                         'text' => $success
                     ];*/
                }
            }
            else{
                dd("fallo aqui?");
                session()->flash('message', ['type' => 'danger', 'text'=>'fallo al crear la carpeta']);
            }
        }
        //return response()->json($response);
        dd("todo ok :S");
        return back();
    }

    public function destroy($item_image_id){


        $item_image = $this->imageItem->find($item_image_id);
        $item_image->load([strtolower(class_basename($this->item))]);

        $success = true;
        try{
            DB::beginTransaction();
            $item_image->delete();
            if ($item_image->featured == true && count($item_image->{strtolower(class_basename($this->item))}->images)>0) {
                $item = $item_image->{strtolower(class_basename($this->item))};
                $image = $item->images->first();
                if ($image) {
                    $image->destacar($item->id);
                }
            }
        }
        catch (\Exception $exception){
            DB::rollBack();
            $success = $exception->getMessage();
        }
        if($success === true){

            DB::commit();
            session()->flash('message', ['type' => 'success', 'text'=>'Imagen eliminada correctamente']);
        }
        else{
            session()->flash('message', ['type' => 'success', 'text'=>$success]);
        }
        return back();

    }

    public function feature($item_id, $image_item_id){
        $item_image = $this->imageItem->find($image_item_id);
        $item_image->destacar($item_id);

        return back();
    }
}
