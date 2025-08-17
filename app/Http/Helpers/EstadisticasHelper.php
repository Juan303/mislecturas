<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;


class EstadisticasHelper
{

    public static function compras()
    {
        $compras = DB::table('usuario_compras_vista')
            ->where('user_id', auth()->user()->id);
        return $compras;
    }

}
