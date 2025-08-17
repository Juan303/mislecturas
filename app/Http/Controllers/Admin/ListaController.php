<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ListaRequest;
use App\Juego;
use App\Lista;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Intervention\Image\ImageManager;

class ListaController extends Controller
{

    private $campos = ['nombre', 'publica', 'estadisticas', 'image', 'publicated_at'];
    private $camposPivot = ['estilos'];

    public function index(){
        $listas = Lista::where('user_id', '=', auth()->user()->id)->get();
        $datos['titulo'] = "Listas";
        $datos['texto_boton_anyadir'] = __("Añadir lista");
        $datos['ruta_create'] = route('lista.create');
        return view('listas.index')->with(compact('listas'))->with($datos);
    }

    public function show(Lista $lista){
        //$product->load('product_images');
        return view('listas.show')->with(compact('lista'));
    }

    public function create(){
        $values = [];
        foreach ($this->campos as $campo){
            $values[$campo] = old($campo);
        }
        $route =  route('lista.store');
        $titulo = 'Agregar lista';
        return view('listas.create_edit')->with(compact('route', 'titulo'))->with($values);
    }

    public function agregarElementoDatatable(Request $request){
        $item_id = $request->input('juego_id');
        $juego = Juego::find($item_id);
        $lista_id = $request->input('lista_id');
        $lista = Lista::find($lista_id);
        try{
            $lista->juegos()->attach($item_id);
            return response()->json(['type' => 'success', 'text' => 'Juego '.$juego->nombre.' añadido correctamente']);
            //print_r("juego añadido correctamente");
        }
        catch (\Exception $exception){
            if($exception->getCode() == 23000){
                return response()->json(['type' => 'warning', 'text' => 'El juego "'.$juego->nombre.'" ya se encuentra en la lista "'.$lista->nombre.'"']);
            }
            return response()->json(['type' => 'danger', 'text' => "Error al agregar el juego a la lista"]);
        }
    }

    public function borrarListaDatatable(Request $request){
        $lista_id = $request->post("item_id");
        $lista = Lista::find($lista_id);
        $success = true;
        DB::beginTransaction();
        try{
            $lista->delete();
        } catch(\Exception $exception){
            $success = $exception->getMessage();
            DB::rollBack();
        }
        if($success === true){
            DB::commit();
            return response()->json(['type' => 'success', 'text' => 'Lista "'.$lista->nombre.'" eliminada correctamente']);
            //session()->flash('message', ['type' => 'success', 'text'=>'Juego eliminado correctamente']);
        }
        else{
            return response()->json(['type' => 'warning', 'text' => $success]);
            //session()->flash('message', ['type' => 'danger', 'text'=>$success]);
        }
    }

    public function store(ListaRequest $request){
        $success = true;
        DB::beginTransaction();
        try{
            $publica = $estadisticas = true;
            if(!$request->has('publica')){
                $publica = false;
            }
            if(!$request->has('estadisticas')){
                $estadisticas = false;
            }

            $lista = Lista::create([
                'estado' => 1,
                'nombre' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'user_id' => auth()->user()->id,
                'image' => $request->input('image'),
                'publica' => $publica,
                'estadisticas' => $estadisticas,
                'publicated_at' => new Carbon($request->input('publicated_at'))
            ]);
           /* $fileName = null;
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = uniqid() . $lista->nombre;
                if($imagePath = $file->storeAs('images', $fileName)){
                    $intervention = new ImageManager(['driver'=>'gd']);
                    $image = $intervention->make(Storage::get($imagePath))->fit(640, 480)->encode();
                    Storage::disk('public')->put('images/listas/'.$lista->id.'/'.$fileName, $image);
                    Storage::disk('public')->delete('images/'.$fileName);
                    $lista->update([
                        'image' => $fileName
                    ]);
                }
            }*/

        } catch (\Exception $exception){
            $success = $exception->getMessage();
            DB::rollBack();
        }
        if($success === true) {
            DB::commit();
            session()->flash('message', ['type' => 'success', 'text' => 'Lista registrada correctamente']);
            //return redirect(route('lista_images.index', ['lista' => $lista->id]));
            return redirect(route('lista.index'));
        }
        else{
            session()->flash('message', ['type' => 'danger', 'text'=>$success]);
            return back();
        }

    }

    public function edit($lista_id){
        $lista = Lista::find($lista_id);
        $values = [];
        foreach ($this->campos as $campo){
            $values[$campo] = old($campo, $lista->$campo);
        }
        $route =  route('lista.update', ['lista' => $lista->id]);
        $titulo = 'Editar lista: '.$lista->nombre;
        return view('listas.create_edit')->with(compact('lista', 'route', 'titulo'))->with($values);
    }

    public function update(ListaRequest $request, $lista_id){
        $lista = Lista::find($lista_id);
        $success = true;
        DB::beginTransaction();
        try{
            $publica = $estadisticas = true;
            if(!$request->has('publica')){
                $publica = false;
            }
            if(!$request->has('estadisticas')){
                $estadisticas = false;
            }
            $lista->update ([
                'estado' => 1,
                'nombre' => $request->input('nombre'),
                'descripcion' => '',
                'image' => $request->input('image'),
                'publica' => $publica,
                'estadisticas' => $estadisticas,
                'publicated_at' => $request->input('publicated_at')
            ]);

        } catch (\Exception $exception){
            $success = $exception->getMessage();
            DB::rollBack();
        }
        if($success === true) {
            DB::commit();
            session()->flash('message', ['type' => 'success', 'text' => 'Lista editada correctamente']);
            //return redirect(route('product_image.index', ['product' => $product->id]));
        }
        else{
            session()->flash('message', ['type' => 'danger', 'text'=>$success]);
        }
        return back();
    }

    public function destroy(Lista $lista){

        $success = true;
        DB::beginTransaction();
        try{
            $images = $lista->images;
            foreach ($images as $image){
                $image->delete();
            }
            $lista->delete();
        } catch(\Exception $exception){
            $success = $exception->getMessage();
            DB::rollBack();
        }
        if($success === true){
            DB::commit();
            //return response()->json(['type' => 'success', 'text' => 'Producto #'.$product->id.' eliminado correctamente']);
            session()->flash('message', ['type' => 'success', 'text'=>'Lista eliminada correctamente']);
        }
        else{
            //return response()->json(['type' => 'warning', 'text' => $success]);
            session()->flash('message', ['type' => 'danger', 'text'=>$success]);
        }
        return back();
    }


}
