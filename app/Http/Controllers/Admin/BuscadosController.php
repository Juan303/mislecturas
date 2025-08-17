<?php

namespace App\Http\Controllers\Admin;

use App\Coleccion;
use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\LibroHelper;
use App\Http\Helpers\UsuarioComicHelper;
use App\UsuarioColeccion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PHPHtmlParser\Dom;
use App\Http\Helpers\ColeccionHelper;

class BuscadosController extends Controller
{
    private const ITEMS_POR_PAGINA = 24;
    public function index(Request $request){
        $comics = LibroHelper::libros()->where('tengo', UsuarioComicHelper::QUIERO);
        //=======FILTROS
        if($request->isMethod('post')){
            $buscar = explode(' ', $request->post('buscar'));
            foreach($buscar as $termino){
                $comics->where(function($q) use ($termino){
                    $q->orWhere('col.titulo', 'LIKE', '%'.$termino.'%');
                    $q->orWhere('c.numero', 'LIKE', '%'.$termino.'%');
                });
            }
        }
        $comics = $comics->paginate(self::ITEMS_POR_PAGINA);
        return view('colecciones.usuario.buscados')->with(['comics' => $comics, 'request'=>$request]);
    }
}
