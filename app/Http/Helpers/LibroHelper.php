<?php
namespace App\Http\Helpers;

use App\Coleccion;
use App\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use PHPHtmlParser\Dom;
use stringEncode\Exception;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class LibroHelper
{
    public const ITEMS_POR_PAGINA = 24;

    //Filtrar comics en una coleccion
    public static function filtrar(Request $request, $libros)
    {
        if (!empty($request->post('lectura'))) {
            if ($request->post('lectura') == 'item-leyendo') {
                $libros = $libros->where('user_id', '=', auth()->user()->id)
                    ->where('estado_lectura', '=', LecturaHelper::ESTADO_LEYENDO);
            } elseif ($request->post('lectura') == 'item-leido') {
               $libros = $libros->where('user_id', '=', auth()->user()->id)
                    ->where('estado_lectura', '=', LecturaHelper::ESTADO_LEIDO);
            } elseif ($request->post('lectura') == 'item-quiero-leer') {
                $libros = $libros->where('user_id', '=', auth()->user()->id)
                    ->where('estado_lectura', '=', LecturaHelper::ESTADO_QUIERO_LEER);
            } else {
                $libros = $libros->whereNull('estado_lectura');
            }
        }

        if (!empty(trim($request->post('buscar')))) {
            $buscar = explode(' ', $request->post('buscar'));
            foreach ($buscar as $termino) {
                $libros = $libros->where(function ($q) use ($termino) {
                    $q->orWhere('titulo', 'LIKE', '%' . $termino . '%');
                });
            }
        }

        return $libros;
    }

    public static function libros(){
        return DB::table("usuario_libros_vista")
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC');
    }
}
