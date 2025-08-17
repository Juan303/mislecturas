<?php
namespace App\Http\Helpers;

use App\HistoricoLectura;

class HistoricoLecturaHelper{

    public static function guardarRegistro($IdLibro, $IdComic, $numeroPaginas, $fechaFinLectura = null){
        $historico = null;
        if($IdLibro != null) {
            $historico = HistoricoLectura::where('libro_id', $IdLibro)
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }else if($IdComic != null){
            $historico = HistoricoLectura::where('comic_id', $IdComic)
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }
        if($historico == null){
            $historico = HistoricoLectura::create([
                'user_id' => auth()->user()->id,
                'comic_id' => $IdComic,
                'libro_id' => $IdLibro,
                'created_at' => $fechaFinLectura == null ? now() : $fechaFinLectura,
                'updated_at' => $fechaFinLectura == null ? now() : $fechaFinLectura,
                'PaginasLeidas' => $numeroPaginas
            ]);
        }
        else if($historico->created_at == null){
            $historico->PaginasLeidas = $numeroPaginas;
            $historico->created_at = $fechaFinLectura == null ? now() : $fechaFinLectura;
            $historico->updated_at = $fechaFinLectura == null ? now() : $fechaFinLectura;
            $historico->save();
        }
        else if($historico->created_at->isToday()){
                $historico->PaginasLeidas = $numeroPaginas;
                $historico->save();
        }
        else if($numeroPaginas != $historico->PaginasLeidas){
            $historico = HistoricoLectura::create([
                'user_id' => auth()->user()->id,
                'comic_id' => $IdComic,
                'libro_id' => $IdLibro,
                'created_at' => $fechaFinLectura == null ? now() : $fechaFinLectura,
                'updated_at' => $fechaFinLectura == null ? now() : $fechaFinLectura,
                'PaginasLeidas' => $numeroPaginas
            ]);
        }
        return $historico;
    }

    public static function borrarRegistros($IdLibro, $IdComic){
        if($IdLibro != null) {
            HistoricoLectura::where('libro_id', $IdLibro)->where('user_id', auth()->user()->id)->delete();
        }else if($IdComic != null){
            HistoricoLectura::where('comic_id', $IdComic)->where('user_id', auth()->user()->id)->delete();
        }
    }
}

?>




