<?php

namespace App\Http\Controllers\Admin;

use App\Coleccion;
use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\LibroHelper;
use App\Http\Helpers\UsuarioComicHelper;
use App\Prestamo;
use App\UsuarioColeccion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PHPHtmlParser\Dom;
use App\Http\Helpers\ColeccionHelper;

class PrestamoController extends Controller
{

    public function index(){
        return view('prestamos.index');
    }

    public function listarPrestamos($direccion){
        try{
            $prestamos = DB::table('usuario_prestamos_vista')
                ->where('direccion', $direccion)
                ->where('user_id', auth()->user()->id)
                ->get();
            return Response::json(['status' => 'success', 'datos' => $prestamos], 200);
        }
        catch(\Exception $e){
            return Response::json(['status' => 'error', 'message' => 'Error al listar prestamos'], 500);
        }
    }

    public function asignarPrestamo(Request $request){
        //return Response::json(['datos' => $request->all()], 200);
        try{
            $prestamo = Prestamo::create([
                'tipo' => $request->tipo,
                'item_id' => $request->item_id,
                'usuario_id' => auth()->user()->id,
                'persona' => $request->persona,
                'direccion' => $request->direccion
            ]);
            return Response::json([
                'status' => 'success', 
                'message' => 'Prestamo asignado correctamente',
                'datos' => $prestamo
            ], 200);
        }
        catch(\Exception $e){
            return Response::json(['status' => 'error', 'message' => 'Error al asignar prestamo'], 500);
        }
    }

    public function devolverPrestamo(Request $request){
        try{
            $prestamo = Prestamo::where('item_id', $request->item_id)->where('usuario_id', auth()->user()->id)->first();
            $prestamo->delete();
            return Response::json([
                'status' => 'success', 
                'message' => 'Prestamo devuelto correctamente'
            ], 200);
        }
        catch(\Exception $e){
            return Response::json(['status' => 'error', 'message' => 'Error al devolver prestamo'], 500);
        }
    }
}
