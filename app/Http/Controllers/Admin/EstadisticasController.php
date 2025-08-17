<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\EstadisticasHelper;


class EstadisticasController extends Controller
{
    public function index(){
        return view('estadisticas.index');
    }

    public function loadEstadisticasAnualesLectura(Request $request){
        $datos['lecturas'] = LecturaHelper::lecturas()->whereIn('estado_lectura', [LecturaHelper::ESTADO_LEIDO]);
        $datos['compras'] = EstadisticasHelper::compras();
        //Filtramos por año y tipo de lectura
        if($request->has('anyo')){
            $datos['lecturas'] = $datos->where('YEAR', $request->anyo);
            $datos['compras'] = $datos->where('YEAR', $request->anyo);
        }
        if($request->has('tipo')){
            $datos['lecturas'] = $datos->where('tipoLectura', $request->tipo);
            $datos['compras'] = $datos->where('tipoCompra', $request->tipo);
        }
        $datos['lecturas'] = $datos['lecturas']->get();
        $datos['compras'] = $datos['compras']->get();
        return response()->json([
            'status' => 'success',
            'data' => $datos
        ]);
    }

    public function loadDatosInteres(){

        $mediaLibrosLeidosPorDia = LecturaHelper::mediaLibrosLeidosPorDia(date('Y'));
        $mediaLibrosLeidosPorSemana = LecturaHelper::mediaLibrosLeidosPorSemana(date('Y'));
        $mediaLibrosLeidosPorMes = LecturaHelper::mediaLibrosLeidosPorMes(date('Y'));
        $totalLibrosLeidos = LecturaHelper::totalLibrosLeidos(date('Y'));
        $totalPaginas = LecturaHelper::totalPaginasLeidas(date('Y'));
        $totalPaginasLeidas = $totalPaginas['paginas_leidas_totales'];
        $totalPaginasLeidasDia = $totalPaginas['paginas_leidas_al_dia'];


        return response()->json(['html' => view('partials.lecturas.bloque-datos-interes')
            ->with(compact(
                'mediaLibrosLeidosPorDia',
                'mediaLibrosLeidosPorSemana',
                'mediaLibrosLeidosPorMes',
                'totalLibrosLeidos',
                'totalPaginasLeidas',
                'totalPaginasLeidasDia'
            ))
            ->render()]);
    }
}
