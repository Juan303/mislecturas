<?php

namespace App\Http\Controllers\Admin;

use App\Coleccion;
use App\Comic;
use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\UsuarioComicHelper;
use App\UsuarioColeccionComics;
use App\UsuarioColeccion;
use App\UsuarioComic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use PHPHtmlParser\Dom;
use App\Http\Helpers\ColeccionHelper;

class ComicController extends Controller
{
    public function store(Request $request){
        $usuario = auth()->user();
        $IdColeccion = $request->post('IdColeccion');
        $IdComic = $request->post('IdComic');
        $accion = $request->post('accion');
        $success = true;
        try {
            DB::beginTransaction();
            //Agregamos o eliminamos el comic

            switch ($accion){
                case 'agregar':
                    $usuarioColeccion = UsuarioColeccion::firstOrCreate(
                        [
                            'user_id' => $usuario->id,
                            'coleccion_id' => $IdColeccion,
                        ],
                        [
                            'user_id' => $usuario->id,
                            'coleccion_id' => $IdColeccion,
                        ]
                    );
                    UsuarioComic::updateOrcreate(
                        [
                            'comic_id' => $IdComic,
                            'usuario_coleccion_id' => $usuarioColeccion->id,
                            'user_id' => $usuario->id,
                        ],
                        [
                            'usuario_coleccion_id' => $usuarioColeccion->id,
                            'comic_id' => $IdComic,
                            'tengo' => UsuarioComicHelper::TENGO,
                            'fechaCompra' => date('Y-m-d'),
                        ]
                    );
                    break;
                case 'quiero':
                    $usuarioColeccion = UsuarioColeccion::firstOrCreate(
                        [
                            'user_id' => $usuario->id,
                            'coleccion_id' => $IdColeccion,
                        ],
                        [
                            'user_id' => $usuario->id,
                            'coleccion_id' => $IdColeccion,
                        ]
                    );
                    UsuarioComic::updateOrCreate([
                            'user_id' => $usuario->id,
                            'comic_id' => $IdComic,
                        ],
                        [
                            'usuario_coleccion_id' => $usuarioColeccion->id,
                            'comic_id' => $IdComic,
                            'tengo' => UsuarioComicHelper::QUIERO,
                            'fechaCompra' => null
                        ]
                    );
                    break;
                case 'eliminar':
                case 'no_quiero':

                    $usuarioComic = UsuarioComic::where([
                        'user_id' => $usuario->id,
                        'comic_id' => $IdComic
                    ])->first();
                    $coleccion = auth()->user()->usuarioColecciones()->where('id', $usuarioComic->usuario_coleccion_id)->first();
                    $usuarioComic->delete();
                    if($coleccion->usuarioComics()->count() <= 0){
                        $coleccion->delete();
                    }
                //Comprobar si la coleccion se queda vacia para eliminarla tambien
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success === true) {
            DB::commit();
            $message = "Se han AGREGADO el manga a tu colección'";
            $type = 'alert-success';
        }
        else{
            $message = $success;
            $type = 'alert-danger';
        }
        return Response::json(['accion' => $accion, 'type' => $type, 'message' => $message, 'idColeccionPersonal' => (isset($usuarioColeccion->id))?$usuarioColeccion->id:null]);
    }

    public function storeSeleccion(Request $request){
        $usuario = auth()->user();
        $IdColeccion = $request->post('IdColeccion');
        $comicsColeccion = Coleccion::find($IdColeccion)->comics()->editados();
        //Si existen los valores numero_inicial y numero_final, se filtran los comics
        if($request->post('numero_inicial') && $request->post('numero_final')){
            $comicsColeccion = $comicsColeccion->where('numero', '>=', $request->post('numero_inicial'))->where('numero', '<=', $request->post('numero_final'));
        }
        $comicsColeccion = $comicsColeccion->get();
        $success = true;
        try {
            DB::beginTransaction();
            $usuarioColeccion = UsuarioColeccion::firstOrCreate(
                [
                    'user_id' => $usuario->id,
                    'coleccion_id' => $IdColeccion,
                ],
                [
                    'user_id' => $usuario->id,
                    'coleccion_id' => $IdColeccion,
                ]);
            foreach ($comicsColeccion as $comic){
                UsuarioComic::updateOrcreate(
                    [
                        'comic_id' => $comic->id,
                        'usuario_coleccion_id' => $usuarioColeccion->id,
                    ],
                    [
                        'user_id' => $usuario->id,
                        'usuario_coleccion_id' => $usuarioColeccion->id,
                        'comic_id' => $comic->id,
                        'tengo' => true,
                        'fechaCompra' => $request->post('fecha_compra')
                    ]);
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
            $idsComicsAgregados = [];
        }
        if($success === true) {
            DB::commit();
            $idsComicsAgregados = $comicsColeccion->pluck('id');
            $message = "Se han AGREGADO todos los mangas a tu colección'";
            $type = 'alert-success';
        }
        else{
            $message = $success;
            $type = 'alert-danger';
        }
        return Response::json([
                                'type' => $type,
                                'message' => $message,
                                'idColeccionPersonal' => (isset($usuarioColeccion->id))?$usuarioColeccion->id:null,
                                'idsComicsAgregados' => $idsComicsAgregados
                            ]);
    }

    public function deleteSeleccion(Request $request){
        $usuario = auth()->user();
        $IdsComics = $request->post('IdsComics');
        $IdColeccion = $request->post('IdColeccion');
        $success = true;
        try {
            DB::beginTransaction();
            $coleccion = auth()->user()->usuarioColecciones()->where('coleccion_id', '=', $IdColeccion)->first();
            //Borramos todos los comics de la coleccion
            auth()->user()->usuarioComics()
                ->where('usuario_coleccion_id', '=', $coleccion->id)
                ->delete();
            $coleccion->delete();
            //Borrar coleccion ya que si se quitan todos de golpe, ya no habria ningun comic en la coleccion
           /* foreach ($IdsComics as $idComic){
                UsuarioComic::where([
                    'user_id' => $usuario->id,
                    'comic_id' => $idComic
                ])->delete();
            }*/
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success) {
            DB::commit();
            $message = "Se han eliminado todos los mangas de tu colección'";
            $type = 'alert-warning';
        }
        else{
            $message = $success;
            $type = 'alert-danger';
        }
        return Response::json(['type' => $type, 'message' => $message]);
    }

    public function favoritosStoreSeleccion(Request $request){
        $usuario = auth()->user();
        $IdColeccion = $request->post('IdColeccion');
        $IdsComics = $request->post('IdsComics');



        if(empty($IdColeccion)){ //estoy en la seccion "Buscados"
            $comics =  Comic::whereIn('id', $IdsComics);
        }
        else{ //estoy en la seccion de colecciones
            $comics = Coleccion::find($IdColeccion)->comics()->editados();
        }
        $comics = $comics->get();
        $success = true;
        try {
            DB::beginTransaction();
            if(empty($IdColeccion)) {
                foreach ($comics as $comic) { //saco la coleccion del comic que quiero insertar
                    $usuarioColeccion = UsuarioColeccion::firstOrCreate(
                        [
                            'user_id' => $usuario->id,
                            'coleccion_id' => $comic->coleccion_id
                        ],
                        [
                            'user_id' => $usuario->id,
                            'coleccion_id' => $comic->coleccion_id
                        ]);
                }
            }
            else { //saco la coleccion del parametro que le llega
                $usuarioColeccion = UsuarioColeccion::firstOrCreate(
                    [
                        'user_id' => $usuario->id,
                        'coleccion_id' => $IdColeccion
                    ],
                    [
                        'user_id' => $usuario->id,
                        'coleccion_id' => $IdColeccion
                    ]);
            }
            foreach ($comics as $comic) {
                UsuarioComic::firstOrCreate(
                    [
                        'user_id' => $usuario->id,
                        'comic_id' => $comic->id

                    ],
                    [
                        'user_id' => $usuario->id,
                        'usuario_coleccion_id' => $usuarioColeccion->id,
                        'comic_id' => $comic->id,
                        'tengo' => UsuarioComicHelper::QUIERO
                    ]
                );
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success === true) {
            DB::commit();
            $message = "Todos los comics de esta colección se han MARCADO como 'buscados'";
            $type = 'alert-success';
        }
        else{
            $message = $success;
            $type = 'alert-danger';
        }
        return Response::json(['type' => $type, 'message' => $message, 'idColeccionPersonal' => (isset($usuarioColeccion->id))?$usuarioColeccion->id:null]);
    }

    public function favoritosDeleteSeleccion(Request $request){
        $IdColeccion = $request->post('IdColeccion');
        $success = true;
        try {
            DB::beginTransaction();
            if(empty($IdColeccion)){ //estoy en la seccion "Buscados"
                $comics =  auth()->user()->usuarioComics()->tengo(UsuarioComicHelper::QUIERO)->get();
                foreach ($comics as $comic){
                    $coleccion = auth()->user()->usuarioColecciones()->where('id', '=', $comic->usuario_coleccion_id)->first();
                    $comic->delete();
                    if(!empty($coleccion) && $coleccion->usuarioComics()->count() < 1){
                        $coleccion->delete();
                    }
                }
            }
            else{ //estoy en la seccion de colecciones
                auth()->user()->usuarioColecciones()->where('coleccion_id', '=', $IdColeccion)->usuarioComics()->tengo(UsuarioComicHelper::QUIERO)->delete();
                $coleccion = auth()->user()->usuarioColecciones()->where('coleccion_id', $IdColeccion)->first();
                if(!empty($coleccion) && $coleccion->usuarioComics()->count() < 1){
                    $coleccion->delete();
                }
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success == true) {
            DB::commit();
            $message = "Todos los comics de esta coleccion se han DESMARCADO como 'buscados'";
            $type = 'alert-warning';
        }
        else{
            $message = $success;
            $type = 'alert-danger';
        }
        return Response::json(['type' => $type, 'message' => $message]);
    }
}
