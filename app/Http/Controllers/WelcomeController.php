<?php

namespace App\Http\Controllers;

use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\RetoHelper;

class WelcomeController extends Controller
{
    public function index(){
        if(auth()->check()){
            $totalPaginas = LecturaHelper::totalPaginasLeidas(date('Y'));
        }
        return view('welcome')->with([
            'lecturasEnCurso' =>  LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEYENDO)->orderBy('fecha_fin_lectura', 'DESC')->take(4)->get(),
/*            'mediaLibrosLeidosPorDia' => LecturaHelper::mediaLibrosLeidosPorDia(date('Y')),
            'mediaLibrosLeidosPorSemana' => LecturaHelper::mediaLibrosLeidosPorSemana(date('Y')),
            'mediaLibrosLeidosPorMes' => LecturaHelper::mediaLibrosLeidosPorMes(date('Y')),
            'totalLibrosLeidos' => LecturaHelper::totalLibrosLeidos(date('Y')),
            'totalPaginas' => LecturaHelper::totalPaginasLeidas(date('Y')),
            'totalPaginasLeidas' => $totalPaginas['paginas_leidas_totales'],
            'totalPaginasLeidasDia' => $totalPaginas['paginas_leidas_al_dia'],
            'retoAnyoActual' => LecturaHelper::retoAnyoActual(),
            'librosAnyoActual' => LecturaHelper::librosAnyoActual(),
            'librosAlMesParaCompletarReto' => RetoHelper::librosAlMesParaCompletaReto(date('Y')),
            'librosALaSemanaParaCompletarReto' => RetoHelper::librosALaSemanaParaCompletarReto(date('Y'))*/
        ]);
    }

    public function login(){
        return view('auth.login');
    }

    public function loadUltimasLecturas(){
        $lecturas = [];
        if(auth()->check()){
            $lecturas = LecturaHelper::lecturas()->where('estado_lectura', LecturaHelper::ESTADO_LEYENDO)->orderBy('fecha_fin_lectura', 'DESC')->take(4)->get();
        }
        //Respondemos con una vista en formato JSON
        return response()->json([
            'html' => view('partials.lecturas.bloque-ultimas-lecturas', ['lecturasEnCurso' => $lecturas])->render()
        ]);
    }
}
