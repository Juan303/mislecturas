<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reto;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\RetoHelper;

class RetoController extends Controller
{
    public function index(){
        $reto = Reto::first();
        //Libros leidos dentro del año actual
        return view('retos.index')->with('reto', $reto);
    }

    public function store(Request $request){
        //Reto del usuario en el año actual
        $reto = auth()->user()->reto()->whereYear('created_at', date('Y'));
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

    public function loadRetoActual(){
        $reto = Reto::whereYear('created_at', date('Y'))->where('user_id', auth()->user()->id)->first();
        //dd(RetoHelper::librosAlMesParaCompletaReto(date('Y')));
        return response()->json(['html' => view('partials.lecturas.bloque-reto-actual')->with([
            'retoAnyoActual' => $reto,
            //'librosAlMesParaCompletarReto' => RetoHelper::librosAlMesParaCompletaReto(date('Y'))
            ]
        )->render()]);
    }
}
