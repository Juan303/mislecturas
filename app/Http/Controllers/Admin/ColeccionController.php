<?php

namespace App\Http\Controllers\Admin;

use App\Coleccion;
use App\Http\Helpers\UsuarioComicHelper;
use App\Lista;
use App\ListadoColeccion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Helpers\ColeccionHelper;
use Illuminate\Support\Facades\Session;
use stringEncode\Exception;

class ColeccionController extends Controller
{

    //======================================Muestra las colecciones de un usuario
    public function index(){
        $coleccionesPersonales = auth()->user()->usuarioColecciones()->orderBy('created_at', 'desc')
            ->with([
                'usuarioComics' => function($q){
                    $q->tengo(UsuarioComicHelper::TENGO)->with(['usuarioLectura']);
                },
                'coleccion' => function($q){
                    $q->with(['comicsEditados']);
                }
            ])->get()->toArray();
        $datosColeccionesGlobales['n_totalColecciones'] = 0;
        $datosColeccionesGlobales['n_totalComics'] = 0;
        $datosColeccionesGlobales['n_comicsTengoEditados'] = 0;
        $datosColeccionesGlobales['n_coleccionesCompletas'] = 0;
        $datosColeccionesGlobales['n_coleccionesIncompletas'] = 0;
        $datosColeccionesGlobales['n_coleccionesAlDia'] = 0;
        foreach($coleccionesPersonales as $coleccionPersonal){
            if(!empty($coleccionPersonal['usuario_comics'])) {
                $datosColeccionesGlobales['n_totalColecciones'] += 1;
                $datosColeccionesGlobales['n_totalComics'] += count($coleccionPersonal['coleccion']['comics_editados']);
                $datosColeccionesGlobales['n_comicsTengoEditados'] += count($coleccionPersonal['usuario_comics']);
                $datosColeccionesGlobales['n_coleccionesCompletas'] += (count($coleccionPersonal['coleccion']['comics_editados']) === count($coleccionPersonal['usuario_comics']) && $coleccionPersonal['coleccion']['completa']) ? 1 : 0;
                $datosColeccionesGlobales['n_coleccionesIncompletas'] += (count($coleccionPersonal['coleccion']['comics_editados']) !== count($coleccionPersonal['usuario_comics'])) ? 1 : 0;
                $datosColeccionesGlobales['n_coleccionesAlDia'] += (count($coleccionPersonal['coleccion']['comics_editados']) === count($coleccionPersonal['usuario_comics']) && !$coleccionPersonal['coleccion']['completa']) ? 1 : 0;
            }
        }

        $datosColeccionesGlobales['n_comicsMeFaltan'] = $datosColeccionesGlobales['n_totalComics']-$datosColeccionesGlobales['n_comicsTengoEditados'];
        return view('colecciones.usuario.index')->with(['datosColeccionesGlobales' => $datosColeccionesGlobales, 'colecciones' => $coleccionesPersonales]);
    }

    public function previsionCompras(){
        $comics = UsuarioComicHelper::proximosLanzamientos(auth()->user()->id);
        $comicsPendientes = UsuarioComicHelper::comprasPendietes(auth()->user()->id);
        return view('colecciones.usuario.previsionCompras', ['comics' => $comics, 'comicsPendientes' => $comicsPendientes]);
    }

    public function listadoColecciones(){
        return view('colecciones.listadoColecciones');
    }

    public function loadListadoColecciones(){
        //Guardamos en sesion el listado de colecciones
        $listadoColecciones = ColeccionHelper::listadoColecciones();
        return response()->json($listadoColecciones);
    }

    //=============================================Muestra una coleccion en concreto
    public function coleccion($id, Request $request){

        //Buscamos la coleccion en la BD
        $coleccion = Coleccion::find($id);
        if(empty($coleccion)){
            $datosColeccion = ColeccionHelper::extraerDatosColeccionListadoManga($id, true, $request);
        }
        else{
            $datosColeccion = ColeccionHelper::extraerDatosColeccionListadoManga($id, false, $request);
        }

        if(!$datosColeccion){
            //mensaje flash
            session()->flash('message', ['type' => 'warning', 'text'=>"No se ha encontrado la colección indicada"]);
            return back();
        }
        //dd($datosColeccion['comics'], $datosColeccion['coleccion'], $datosColeccion['comics_publicados']);
        return view('colecciones.index')->with(['comics_publicados' => $datosColeccion['comics_publicados'],  'datosColeccion' => $datosColeccion['coleccion'], 'comics'=> $datosColeccion['comics'], 'request' => $request]);
    }

    //============================================ listado coleccion (BD)
    public function getListadoColeccion(Request $request, $reload = false){

        $buscar = $request->buscar;
        if(!session()->has('listadoColecciones')){
            session(['listadoColecciones' => Coleccion::all()]);
        }

        $coleccionesBD =  session('listadoColecciones');
        //dd($coleccionesBD);
        //$coleccionesBD = $coleccionesBD->where('titulo', 'like', '%' . $buscar . '%')->all();
        //dd(session('listadoColecciones'));
        return $coleccionesBD;

    }
    //============================================ listado coleccion (listado Manga)
    public function getListadoColeccionListadoManga(Request $request){

        $buscar = $request->buscar;
        $buscar = str_replace(" ", "+", $buscar);
        $url = "https://www.listadomanga.es/buscar.php?b=".$buscar;
        $datos = ColeccionHelper::culr($url);
        return $datos;
    }

    //============================================ Datos coleccion (indica la ruta a cargar cuando se elige una coleccion del desplegable)
    public function getDatosColeccionListadoManga(Request $request){
        $id = $request->id;
        return Response::json(array('success'=>true,'result'=>route('coleccion.index', ['id' => $id])));
    }


    //=============================================Elimina una coleccion
    public function destroy(Request $request){
        $coleccionNombre = $request->post('item_nombre');
        $id = $request->post('item_id');
        $success = true;
        try{
            DB::beginTransaction();
            $coleccion = auth()->user()->usuarioColecciones()->find($id);
            if(empty($coleccion)){
                throw new Exception('Error al eliminar la colección');
            }
            //Eliminamos los comics de la coleccion
            $usuarioComics = $coleccion->usuarioComics;
            if(!empty($usuarioComics)){
                foreach ($usuarioComics as $usuarioComic){
                    $usuarioComic->delete();
                }
            }
            $coleccion->delete();
        }
        catch(\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success !== true){
            $message = $success;
            $type = 'warning';
        }
        else{
            DB::commit();
            $message = "Se ha eliminado la colección ".$coleccionNombre. " correctamente";
            $type = 'success';
        }
        session()->flash('message', ['type' => $type, 'text'=>$message]);
        return back();
    }


}
