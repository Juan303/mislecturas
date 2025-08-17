<?php
namespace App\Http\Helpers;

use App\Models\UsuarioComic;
use Illuminate\Support\Facades\DB as BD;

class UsuarioComicHelper{
    public const NO_TENGO = 0;
    public const TENGO = 1;
    public const QUIERO = 2;

    public function comicsBuscados($usuarioId){
        return UsuarioComic::where('user_id', $usuarioId)->where('tengo', self::QUIERO)->get();
    }

    public static function proximosLanzamientos($usuarioId){
        //COn los links de la paginación
        return BD::table('prevision_compras_vista')
            ->where('user_id', $usuarioId)
            //La fecha viene en formato string como '15 Enero 2021'. Necesito convertir eso a un formato de fecha para poder ordenar
            ->orderBy('created_at', 'asc')
            //necesito que la variable del paginate sea "comics" para que funcione con la vista
            ->paginate(30, ['*'], 'comics');
    }

    public static function comprasPendietes($usuarioId){
        //COn los links de la paginación
        return BD::table('compras_pendientes_vista')
            ->where('user_id', $usuarioId)
            //La fecha viene en formato string como '15 Enero 2021'. Necesito convertir eso a un formato de fecha para poder ordenar
            ->orderBy('created_at', 'asc')
            //necesito que la variable del paginate sea "comicsPendientes" para que funcione con la vista
            ->paginate(30, ['*'], 'comicsPendientes');
    }
}
?>
