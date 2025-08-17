<?php

namespace App\Http\Controllers\Admin;

use App\Estilo;
use App\Http\Requests\BuscadorRequest;
use App\Http\Requests\SistemaRequest;
use App\Http\Requests\UserRequest;
use App\Juego;
use App\Sistema;
use App\Http\Controllers\Controller;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    private $campos = ['email'];
    private $camposPivot = ['estilos'];


    public function index(){
        return view('home');
    }

    public function update(UserRequest $request){
        $success = true;
        DB::beginTransaction();
        try{

            $visible_wishlist = false;
            if($request->has('visible_wishlist')){
                $visible_wishlist = true;
            }

            auth()->user()->update ([
                'email' => $request->input('email'),
            ]);

        } catch (\Exception $exception){
            $success = $exception->getMessage();
            DB::rollBack();
        }
        if($success === true) {
            DB::commit();
            session()->flash('message', ['type' => 'success', 'text' => 'Usuario editado correctamente']);
            //return redirect(route('product_image.index', ['product' => $product->id]));
        }
        else{
            session()->flash('message', ['type' => 'danger', 'text'=>$success]);
        }
        return back();

    }
}
