<?php

namespace App\Http\Controllers\Admin;

use App\Coleccion;
use App\Comic;
use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\RetoHelper;
use App\Reto;
use App\UsuarioLectura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Helpers\HistoricoLecturaHelper;
use Carbon\Carbon;

class LecturaController extends Controller
{
    private const ITEMS_POR_PAGINA = 24;

    public function index(Request $request, $estado = null){
        //$comics = self::getBaseQuery();
        //======NUMERO DE COMICS LEIDOS/LEYENDO/QUIERO LEER
        $nComics = [
            'nComicsLeidos' => LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEIDO)->count(),
            'nComicsNoLeidos' => LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_NO_LEIDO)->count(),
            'nComicsLeyendo' => LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEYENDO)->count(),
            'nComicsQuieroLeer' => LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_QUIERO_LEER)->count()
        ];

        switch($estado){
            case('leidos'):
                $comics = LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEIDO)->orderBy('fecha_fin_lectura', 'DESC');
                break;
            case('quiero-leer'):
                $comics = LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_QUIERO_LEER)->orderBy('fecha_quiero_leer', 'DESC');
                break;
            case('leyendo'):
            default:
                $comics = LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEYENDO)->orderBy('fecha_inicio_lectura', 'DESC');

        }

        if($request->isMethod('post')){
            $buscar = explode(' ', $request->post('buscar'));
            foreach($buscar as $termino){
                $comics->where(function($q) use ($termino){
                    $q->orWhere('tituloColeccion', 'LIKE', '%'.$termino.'%');
                    $q->orWhere('numero', 'LIKE', '%'.$termino.'%');
                    $q->orWhere('numero', 'LIKE', '%'.$termino.'%');
                });
            }
        }

        $comics = $comics->paginate(self::ITEMS_POR_PAGINA);
        return view('lecturas.index')->with(['numeroComics' => $nComics, 'comics' => $comics, 'estado' => $estado, 'request' => $request]);
    }

    //========================================================================================RESUMEN
    public function resumen(){
        return view('lecturas.resumen');
    }

    public function ultimasLecturas(){
        $lecturasEnCurso =  LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEYENDO)->orderBy('fecha_fin_lectura', 'DESC')->take(4)->get();
        return response()->json([
            'html' => view('partials.lecturas.bloque-ultimas-lecturas')->with(compact('lecturasEnCurso'))->render()
        ]);
    }

    public function loadResumen(Request $request){
        try {
            $comicsPorFecha = [];
            $totales = [];
            $comics = LecturaHelper::lecturas()
                ->where('estado_lectura', LecturaHelper::ESTADO_LEIDO)
                ->whereYear('fecha_fin_lectura', $request->anyo)
                ->get();

            if($comics->count() == 0){
                return response()->json([
                    'html' => view('lecturas.partials.listadoResumen')->with(compact('comicsPorFecha'))->render(),
                    'totales' => 0]);
            }
            if($request->tipo != ''){
                $comics = $comics->where('tipoLectura', $request->tipo);
            }
            foreach ($comics as $comic) {
                $fecha = new Carbon($comic->fecha_fin_lectura);
                $comicsPorFecha[$fecha->year][$fecha->month][] = $comic;
                $totales[$fecha->year] = isset($totales[$fecha->year]) ? $totales[$fecha->year] + 1 : 1;
            }
            //ordenar por mes
            foreach ($comicsPorFecha as $year => $meses) {
                krsort($meses);
                $comicsPorFecha[$year] = $meses;
            }
            return response()->json([
                'html' => view('lecturas.partials.listadoResumen')->with(compact('comicsPorFecha'))->render(),
                'totales' => $totales[$request->anyo]]);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //========================================================================================RETOS
    public function retos(){
        //$retoAnyoActual = LecturaHelper::retoAnyoActual();
        $retosAnyosAnteriores = LecturaHelper::retoAnyosAnteriores();
        //$retoActual = LecturaHelper::retoAnyoActual();
        // $librosAnyoActual = LecturaHelper::librosAnyoActual();
        // $librosAnyosAnteriores = LecturaHelper::librosAnyosAnteriores();
        //Libros leidos dentro del año actual
        return view('lecturas.retos')->with(compact('retosAnyosAnteriores'));
    }

    public function loadRetoActual($zona = null){
        $retoAnyoActual = LecturaHelper::retoAnyoActual();
        $librosAnyoActual = LecturaHelper::librosAnyoActual();
        $librosAlMesParaCompletarReto = RetoHelper::librosAlMesParaCompletaReto(date('Y'));
        $librosALaSemanaParaCompletarReto = RetoHelper::librosALaSemanaParaCompletarReto(date('Y'));
        return response()->json(['html' => view('partials.lecturas.bloque-reto-actual')->with(compact(
            'retoAnyoActual', 'librosAnyoActual', 'zona', 'librosAlMesParaCompletarReto', 'librosALaSemanaParaCompletarReto'
        ))->render()]);
    }

    public function storeReto(Request $request){

        $reto = auth()->user()->reto()->whereYear('created_at', date('Y'))->first();
        try {
            DB::beginTransaction();
            if ($reto == null) {
                Reto::create([
                    'user_id' => auth()->user()->id,
                    'CantidadAnual' => $request->CantidadAnual,
                ]);
            } else {
                $reto->CantidadAnual = $request->CantidadAnual;
                $reto->save();
            }
            DB::commit();
            return response()->json(['message' => 'Reto guardado correctamente'], 200);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    //========================================================================================LECTURAS
    public function datosLectura($idItem, $tipoLectura){
        $item = DB::table("usuario_libros_vista")
            ->where('tipoLectura', $tipoLectura)
            ->where('id', $idItem)->first();
        return Response::json(['idItem' => $item->id, 'datosLectura' => $item]);
    }

    public function cambiarPaginasLeidas(Request $request, $tipoLectura){
        return LecturaHelper::cambiarPaginasLeidas($request, $tipoLectura);
    }

    public function historicoLecturas($idLibro, $tipoLectura){
        return LecturaHelper::historicoLecturas($idLibro, $tipoLectura);
    }

    public function store(Request $request){
        $usuario = auth()->user();
        $IdComic = $request->post('IdComic');
        $accion = $request->post('accion');
        $success = true;
        $comic = Comic::find($IdComic);
        try {
            DB::beginTransaction();
            switch ($accion){
                case 'leyendo':
                    $lectura = UsuarioLectura::updateOrCreate(
                        [
                            'user_id' => $usuario->id,
                            'comic_id' => intval($IdComic)
                        ],
                        [
                            'user_id' => $usuario->id,
                            'comic_id' => intval($IdComic),
                            'fecha_inicio_lectura' => now(),
                            'fecha_fin_lectura' => null,
                            'paginas_totales' => ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor,
                            'estado_lectura' => LecturaHelper::ESTADO_LEYENDO
                        ]);
                        HistoricoLecturaHelper::guardarRegistro($IdLibro = null, intval($IdComic), 0);
                    break;
                case 'leido':
                    $lectura = UsuarioLectura::updateOrCreate(
                        [
                            'user_id' => $usuario->id,
                            'comic_id' => intval($IdComic)
                        ],
                        [
                            'user_id' => $usuario->id,
                            'comic_id' => intval($IdComic),
                            'fecha_fin_lectura' => now(),
                            'paginas_leidas' => ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor,
                            'paginas_totales' => ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor,
                            'estado_lectura' => LecturaHelper::ESTADO_LEIDO
                        ]);

                        //Guardar en el historico de lecturas. Si existe hay que comprobar que el numero de paginas leidas sea mayor
                        //Ver si existe un historico de lectura para este comic
                        HistoricoLecturaHelper::guardarRegistro($IdLibro = null, intval($IdComic), $comic->numeroPaginasBN);

                    break;
                case 'quiero leer':
                    $lectura = UsuarioLectura::updateOrCreate(
                        [
                            'user_id' => $usuario->id,
                            'comic_id' => intval($IdComic)
                        ],
                        [
                            'user_id' => $usuario->id,
                            'comic_id' => intval($IdComic),
                            'paginas_leidas' => 0,
                            'fecha_fin_lectura' => null,
                            'fecha_inicio_lectura' => null,
                            'fecha_quiero_leer' => now(),
                            'paginas_totales' => ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor,
                            'estado_lectura' => LecturaHelper::ESTADO_QUIERO_LEER
                        ]);
                        HistoricoLecturaHelper::borrarRegistros($IdLibro = null, intval($IdComic));
                    break;
                case 'no leido':
                    $lectura = UsuarioLectura::where([
                        'user_id' => $usuario->id,
                        'comic_id' => intval($IdComic),
                    ])->delete();
                    HistoricoLecturaHelper::borrarRegistros($IdLibro = null, intval($IdComic));
            }
        }
        catch (TokenMismatchException $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success === true) {
            DB::commit();
            $message = "Se ha cambiado el estado de la lectura correctamente'";
            $type = 'alert-success';
        }
        else{
            $message = $success;
            $type = 'alert-danger';
        }
        return Response::json(['accion' => $accion, 'type' => $type, 'message' => $message, 'idComic' => $IdComic, 'datosLectura' => $lectura]);
    }

    public function storeSeleccion(Request $request){
        $usuario = auth()->user();
        $estado = $request->post('estado');
        $IdColeccion = $request->post('IdColeccion');
        if(empty($IdColeccion)) { //estoy en la seccion "Buscados"
            $estadoActual = $request->post('estadoActual');
            $comics = auth()->user()->usuarioLecturas();
            switch($estadoActual){
                case 'leidos':
                    $comics->leidos();
                    break;
                case 'leyendo':
                    $comics->leyendo();
                    break;
                case 'quiero-leer':
                    $comics->quieroLeer();
                    break;
            }
            $comics = $comics->with('comic')->get();
        }
        else{
            $comics = Coleccion::find($IdColeccion)->comics();
            //Si existen los valores numero_inicial y numero_final, se filtran los comics
            if($request->post('numero_inicial') && $request->post('numero_final')){
                $comics = $comics->where('numero', '>=', $request->post('numero_inicial'))->where('numero', '<=', $request->post('numero_final'));
            }
        }
        $comics = $comics->get();
        $success = true;
        try {
            DB::beginTransaction();
            foreach ($comics as $comic){
                if(empty($IdColeccion)){
                    $comic = $comic->comic;
                }
                if($estado == LecturaHelper::ESTADO_QUIERO_LEER){
                    $paginas_leidas = 0;
                }
                elseif($estado == LecturaHelper::ESTADO_LEYENDO){
                    $paginas_leidas = $comic->paginas_leidas;
                }
                else{
                    $paginas_leidas = ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor;
                }

                $lectura = UsuarioLectura::updateOrcreate(
                    [
                        'user_id' => $usuario->id,
                        'comic_id' => $comic->id
                    ],
                    [
                        'user_id' => $usuario->id,
                        'comic_id' => $comic->id,
                        'fecha_fin_lectura' => ($estado != LecturaHelper::ESTADO_LEIDO)?null:$request->post('fecha_fin_lectura'),
                        'paginas_leidas' => $paginas_leidas,
                        'paginas_totales' => ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor,
                        'estado_lectura' => $estado
                    ]);

                    //Guardamos el historico de lecturas
                    if($estado == LecturaHelper::ESTADO_LEIDO){
                        HistoricoLecturaHelper::guardarRegistro($IdLibro = null, $comic->id, $paginas_leidas, $request->post('fecha_fin_lectura'));
                    }
            }
            switch($estado){
                case LecturaHelper::ESTADO_LEIDO:
                    $estado = 'leido';
                    break;
                case LecturaHelper::ESTADO_QUIERO_LEER:
                    $estado = 'quiero leer';
                    break;
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }
        if($success == true) {
            DB::commit();
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
                                'estado' => $estado,
                                'datosLectura' => $lectura,
                                'idsCambiados' => $comics->pluck('id')
                            ]);
    }

    public function deleteSeleccion(Request $request){
        $usuario = auth()->user();
        $IdColeccion = $request->post('IdColeccion');
        if(empty($IdColeccion)) { //estoy en la seccion "Buscados"
            $estadoActual = $request->post('estadoActual');
            $comics = auth()->user()->usuarioLecturas();
            switch($estadoActual){
                case 'leidos':
                    $comics->leidos();
                    break;
                case 'leyendo':
                    $comics->leyendo();
                    break;
                case 'quiero-leer':
                    $comics->quieroLeer();
                    break;
            }
            $IdsComics = $comics->pluck('comic_id');
        }
        else{
            $IdsComics = Coleccion::find($IdColeccion)->comics()->pluck('id');
            //Borramos los registros del historico de lecturas
            foreach($IdsComics as $IdComic){
                HistoricoLecturaHelper::borrarRegistros($IdLibro = null, $IdComic);
            }
        }

        $success = true;
        try {
            DB::beginTransaction();
            auth()->user()->usuariolecturas()->whereIn('comic_id', $IdsComics)->delete();
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




}
