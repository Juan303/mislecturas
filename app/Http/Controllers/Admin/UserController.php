<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(15);

        return view('admin.users.index')->with(compact('users'));
    }

    public function edit(User $user){
        return view('admin.users.edit')->with(compact('user'));
    }

    public function destroy(User $user){
        $success = true;

        DB::beginTransaction();
        try{
            $user->delete();
        } catch(\Exception $exception){
            $success = $exception->getMessage();
            DB::rollBack();
        }
        if($success === true){
            DB::commit();
            //return response()->json(['type' => 'success', 'text' => 'Producto #'.$product->id.' eliminado correctamente']);
            session()->flash('message', ['type' => 'success', 'text'=>'Usuario eliminado correctamente']);
        }
        else{
            //return response()->json(['type' => 'warning', 'text' => $success]);
            session()->flash('message', ['type' => 'danger', 'text'=>$success]);
        }
        return back();
    }
}
