<?php
namespace App\Http\Helpers;


use App\HistoricoLectura;
use App\Libro;
use App\Comic;
use App\Reto;
use App\UsuarioLectura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class LecturaHelper{

    public const ESTADO_NO_LEIDO = 0;
    public const ESTADO_LEYENDO = 1;
    public const ESTADO_LEIDO = 2;
    public const ESTADO_QUIERO_LEER = 3;

    public static function cambiarPaginasLeidas(Request $request, $tipoLectura){
        $IdItem = $request->post('idItem');
        $paginasLeidas = $request->post('paginasLeidas');
        if($tipoLectura == 'libro'){
            $item = Libro::find((int)$IdItem);
            if($item == null){
                $libro = Libro::find((int)$IdItem);
                $item = UsuarioLectura::create(
                    [
                        'user_id' => auth()->user()->id,
                        'libro_id' => intval($IdItem),
                        'fecha_inicio_lectura' => now(),
                        'fecha_fin_lectura' => null,
                        'paginas_totales' => $libro->numeroPaginas,
                        'estado_lectura' => LecturaHelper::ESTADO_LEYENDO
                    ]);
            }
        }
        else if($tipoLectura == 'manga'){
            $item = UsuarioLectura::where('user_id', auth()->user()->id)->where('comic_id', $IdItem)->first();
            if($item == null){
                $comic = Comic::find((int)$IdItem);
                $item = UsuarioLectura::create(
                    [
                        'user_id' => auth()->user()->id,
                        'comic_id' => intval($IdItem),
                        'fecha_inicio_lectura' => now(),
                        'fecha_fin_lectura' => null,
                        'paginas_totales' => ($comic->numeroPaginasBN > 0)?$comic->numeroPaginasBN:$comic->numeroPaginasColor,
                        'estado_lectura' => LecturaHelper::ESTADO_LEYENDO
                    ]);
            }
        }

        try {
            DB::beginTransaction();

            if($item->paginas_leidas == $paginasLeidas){
                return Response::json([
                    'type' => 'alert-warning',
                    'message' => "El número de páginas leídas no ha cambiado",
                    'idItem' => $IdItem,
                    'tipoLectura' => $tipoLectura,
                    'datosLectura' => $item]);
            }
            $item->update([
                'paginas_leidas' => $paginasLeidas
            ]);
            if($paginasLeidas == $item->paginas_totales){
                $item->update([
                    'estado_lectura' => LecturaHelper::ESTADO_LEIDO,
                    'fecha_inicio_lectura' => ($item->fecha_inicio_lectura == null)?now():$item->fecha_inicio_lectura,
                    'fecha_fin_lectura' => now()

                ]);
            }
            else if($paginasLeidas > 0 && $paginasLeidas < $item->paginas_totales){
                $item->update([
                    'estado_lectura' => LecturaHelper::ESTADO_LEYENDO,
                    'fecha_inicio_lectura' => ($item->fecha_inicio_lectura == null)?now():$item->fecha_inicio_lectura,
                    'fecha_fin_lectura' => null
                ]);
            }
            else{
                $item->update([
                    'estado_lectura' => $item->estado_lectura,
                    'fecha_inicio_lectura' => null,
                    'fecha_fin_lectura' => null
                ]);
            }
            if($tipoLectura == 'libro'){
                HistoricoLecturaHelper::guardarRegistro($item->id, null, $paginasLeidas);
            }
            else if($tipoLectura == 'manga'){
                HistoricoLecturaHelper::guardarRegistro(null, $item->comic_id, $paginasLeidas);
            }
            DB::commit();
            return Response::json([
                'type' => 'alert-success',
                'message' => "Se ha cambiado el número de páginas leídas correctamente",
                'idItem' => $IdItem,
                'tipoLectura' => $tipoLectura,
                'datosLectura' => $item]);

        }
        catch (\Exception $e){
            DB::rollBack();
            return Response::json([
                'type' => 'alert-danger',
                'message' => $e->getMessage(),
                'idItem' => $IdItem,
                'tipoLectura' => $tipoLectura,
                'datosLectura' => $item]);
        }
    }

    public static function historicoLecturas($idItem, $tipoLectura){
        $historico = DB::table('historico_lecturas');
        if($tipoLectura == 'libro'){
            $historico->where('libro_id', $idItem);
        }
        else if($tipoLectura == 'manga'){
            $historico->where('comic_id', $idItem);
        }
        $historico = $historico->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        $item = self::lecturas()
        ->where(function($q) use ($idItem, $tipoLectura){
            $q->where('id', $idItem);
            $q->where('tipoLectura', $tipoLectura);
        })->first();

        if($item == null){
            if($tipoLectura == 'manga'){
                $item = Comic::find($idItem);
                $item['paginas_totales'] = $item['numeroPaginasBN'] + $item['numeroPaginasColor'];
                $item['paginas_leidas'] = 0;
            }
            else{
                $item = Libro::find($idItem);
            }
        }

        return response()->json(['historico' => $historico, 'item' => $item]);
    }

    // MEDIAS DE LECTURAS
    public static function medialibrosLeidosPorDia($anyo = null){
        $nLecturasDia = self::lecturas()
            ->select(DB::raw('COUNT(*) as total'), DB::raw('DATE(fecha_fin_lectura) as fecha'))
            ->groupBy(DB::raw('DATE(fecha_fin_lectura)'))
            ->when($anyo, function ($query) use ($anyo) {
                return $query->whereYear('fecha_fin_lectura', $anyo);
            })
            ->get();

        // Suma total de lecturas y establece el número de días según el año (para considerar solo hasta el día de hoy)
        $nLecturas = $nLecturasDia->sum('total');
        $nDias = $anyo ? (date('z') + 1) : (self::lecturas()->min(DB::raw('DATEDIFF(NOW(), fecha_fin_lectura)')) + 1);

        // Calcula la media
        $media = ($nDias > 0) ? round($nLecturas / $nDias, 2) : 0;

        return $media;
    }

    public static function mediaLibrosLeidosPorSemana($anyo = null){
        // Filtro por año (si está definido) y cuenta lecturas semanales
        $nLecturasSemana = self::lecturas()
            ->select(DB::raw('COUNT(*) as total'), DB::raw('DATE_FORMAT(fecha_fin_lectura, "%Y-%u") as fecha'))
            ->groupBy(DB::raw('DATE_FORMAT(fecha_fin_lectura, "%Y-%u")'))
            ->when($anyo, function ($query) use ($anyo) {
                return $query->whereYear('fecha_fin_lectura', $anyo);
            })
            ->get();

        // Suma total de lecturas y establece el número de semanas según el año (para considerar solo hasta la semana actual)
        $nLecturas = $nLecturasSemana->sum('total');
        $nSemanas = $anyo ? date('W') - 1 : (self::lecturas()->min(DB::raw('TIMESTAMPDIFF(WEEK, fecha_fin_lectura, NOW())')));
        //Le sumamos a la semana la parte proporcional de la semana actual
        $nSemanas += date('N') / 7;

        // Calcula la media
        $media = ($nSemanas > 0) ? round($nLecturas / $nSemanas, 2) : 0;

        return $media;
    }

    public static function mediaLibrosLeidosPorMes($anyo = null){
        // Filtro por año (si está definido) y cuenta lecturas mensuales
        $nLecturasMes = self::lecturas()
            ->select(DB::raw('COUNT(*) as total'), DB::raw('DATE_FORMAT(fecha_fin_lectura, "%Y-%m") as fecha'))
            ->groupBy(DB::raw('DATE_FORMAT(fecha_fin_lectura, "%Y-%m")'))
            ->when($anyo, function ($query) use ($anyo) {
                return $query->whereYear('fecha_fin_lectura', $anyo);
            })
            ->get();

        // Suma total de lecturas y establece el número de meses según el año (para considerar solo hasta el mes actual)
        $nLecturas = $nLecturasMes->sum('total');
        $nMeses = $anyo ? date('n') - 1 : (self::lecturas()->min(DB::raw('TIMESTAMPDIFF(MONTH, fecha_fin_lectura, NOW())')));
        //Le sumamos al mes la parte proporcional del mes actual
        $nMeses += date('j') / date('t');

        // Calcula la media
        $media = ($nMeses > 0) ? round($nLecturas / $nMeses, 2) : 0;

        return $media;
    }

    public static function totalLibrosLeidos($anyo = null){
        $nLecturas = self::lecturas();
        if($anyo != null){
            $nLecturas->whereYear('fecha_fin_lectura', $anyo);
        }
        return $nLecturas->where('estado_lectura', LecturaHelper::ESTADO_LEIDO)->count();
    }

    public static function totalPaginasLeidas($anyo = null){
        $nLecturas = self::lecturas()->whereIn('estado_lectura', [LecturaHelper::ESTADO_LEIDO, LecturaHelper::ESTADO_LEYENDO]);
        if($anyo != null){
            $nLecturas->whereYear('fechaUltimaLectura', $anyo);
        }
        $panginas_leidas_totales = $nLecturas->sum('paginas_leidas');
        //Calcular las paginas leidas al dia. Dividimos el total de paginas leidas entre el numero de dias que han pasado desde el inicio del año
        $paginas_leidas_al_dia = $panginas_leidas_totales / (date('z') + 1);

        return [
                'paginas_leidas_totales' => $panginas_leidas_totales,
                'paginas_leidas_al_dia' => $paginas_leidas_al_dia,
        ];
    }

    public static function lecturas(){
        return DB::table("usuario_lecturas_vista")
            ->where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'DESC');
    }

    public static function librosAnyoActual(){
        return  DB::table("usuario_lecturas_vista")
            ->whereYear('fecha_fin_lectura', date('Y'))
            ->where('user_id', auth()->user()->id)
            ->where('estado_lectura', LecturaHelper::ESTADO_LEIDO)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    public static function librosAnyosAnteriores(){
        return DB::table("usuario_lecturas_vista")
                ->whereYear('fecha_fin_lectura', '<', date('Y'))
                ->where('user_id', auth()->user()->id)
                ->where('estado_lectura', LecturaHelper::ESTADO_LEIDO)
                ->orderBy('updated_at', 'DESC');
    }

    public static function retoAnyoActual(){
        return DB::table('retos_vista')->where('user_id', auth()->user()->id)
            ->where('anyoReto', date('Y'))
            ->orderBy('anyoReto', 'DESC')->first();
    }

    public static function retoAnyosAnteriores(){
        return DB::table('retos_vista')->where('user_id', auth()->user()->id)
            ->where('anyoReto', '<', date('Y'))
            ->orderBy('anyoReto', 'DESC')->get();
    }

}

?>
