<?php

namespace App\Http\Controllers;


use App\Coleccion;
use App\ListadoColeccion;
use App\User;
use App\UsuarioColeccion;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use PHPHtmlParser\Dom;
use App\Http\Helpers\ColeccionHelper;



class ScrapperController extends Controller
{

    public static function extraerListadoManga($ncolecciones = null){
        //creamos un fichero de log en modo append
        //Si no existe el archivo lo creamos en modo escritura
        $tiempoInicial = microtime(true);
        $nombreLogScrapper = date('d-m-Y')."_logScrapper.txt";
        if(!file_exists(storage_path('logs/'.$nombreLogScrapper))){
            $fp = fopen(storage_path('logs/'.$nombreLogScrapper), 'w');
        }
        else{
            $fp = fopen(storage_path('logs/'.$nombreLogScrapper), 'a');
        }
        fwrite($fp, "\r\n".date('d/m/Y H:i:s')."======================================================INICIO PROCESO DE EXTRACCIÓN DE DATOS\r\n");
        try{
            $idsListadoManga = [];
            $listadoColeccionesListadoManga = self::extraerDatosListadoColecciones();
            foreach ($listadoColeccionesListadoManga as $dato){
                //imprimimos el atributo href
                $url = explode('=',$dato->getAttribute('href'));
                $idsListadoManga[] = $url[count($url)-1];
            }
            $cont = 1;
            $n_colecciones_nuevas = $n_colecciones_actualizadas = $n_colecciones_procesadas = 0;

            if(!empty($ncolecciones) && $ncolecciones !== 'all'){
                $ids = [$ncolecciones];
            }
            else{
                $ids = [];
                $usuarios = User::with([
                        'usuarioColecciones' => function($query){
                            $query->with('coleccion');
                        }
                    ])->get();
                $colecciones = Coleccion::all()->pluck('id')->toArray();
                foreach ($usuarios as $usuario){
                    $coleccionesUsuario = $usuario->usuarioColecciones;
                    foreach ($coleccionesUsuario as $coleccionUsuario){
                        if(!in_array($coleccionUsuario->coleccion_id, $ids)){
                            $ids[] = $coleccionUsuario->coleccion_id;
                        }
                    }
                }
                foreach ($idsListadoManga as $idListadoManga){
                    if(!in_array($idListadoManga, $colecciones)){
                        $ids[] = $idListadoManga;
                    }
                }
            }
            //dd($ids);
            foreach($ids as $id){
                $idTratado = str_pad($id, 4, '0', STR_PAD_LEFT);
                fwrite($fp, "[".$cont."] procesando colección: [" . $idTratado . "]...\t");
                try {

                    ColeccionHelper::extraerDatosColeccionListadoManga($id, true);
                    fwrite($fp, "\t\t[ACTUALIZADA]");
                    $n_colecciones_actualizadas += 1;
                    $n_colecciones_procesadas += 1;
                }
                catch (\Exception $e){
                    fwrite($fp,"...ERROR (".$e->getMessage(). ")\r\n");
                }
                fwrite($fp,"...OK\r\n");
                $cont++;
            }
            fwrite($fp,"===========================================RESUMEN\r\n");
            fwrite($fp,"- Colecciones procesadas: ".$n_colecciones_procesadas."\r\n");
            fwrite($fp,"- Colecciones actualizadas: ".$n_colecciones_actualizadas."\r\n");
            fwrite($fp,"- Colecciones nuevas: ".$n_colecciones_nuevas."\r\n");


            session()->flash('message', ['type' => 'success', 'text' => 'Proceso de extracción de datos finalizado correctamente.']);
        }
        catch (\Exception $e){
            session()->flash('message', ['type' => 'warning', 'text' => $e->getMessage()]);
            return 1;
        }
        $tiempoTotal = microtime(true) - $tiempoInicial;
        fwrite($fp, "\r\nTIEMPO TOTAL DE PROCESO: ".round($tiempoTotal, 0)." segundos (".round($tiempoTotal/60, 2) ." minutos)\r\n");
        fwrite($fp, date('d/m/Y H:i:s')."======================================================FIN PROCESO DE EXTRACCIÓN DE DATOS\r\n");
        fclose($fp);
        ColeccionHelper::actualizarPaginasNoEditados();
        ColeccionHelper::actualizarLecturasMangasLeidos();
       //volvemos a la página anterior
        if($ncolecciones != null){
            return redirect('colecciones/coleccion/'.$ncolecciones);
        }
    }


    public static function crearCopiasSeguridadTablas(){
        $tablas = ['colecciones', 'comics'];
        foreach ($tablas as $tabla){
            DB::statement('CREATE TABLE IF NOT EXISTS '.$tabla.'_bk LIKE '.$tabla);
            DB::statement('TRUNCATE TABLE '.$tabla.'_bk');
            DB::statement('INSERT '.$tabla.'_bk SELECT * FROM '.$tabla);
        }
    }

    public static function procesarAutores(){
        try {
            $fp = fopen(storage_path('logs/resultado_autores.txt'), 'w');
            $colecciones = Coleccion::all();
            foreach ($colecciones as $coleccion) {
                $datosColeccion = $coleccion->datosColeccion;
                $autor = [];
                if (isset($datosColeccion['guion'])) {
                    $autor[] = $datosColeccion['guion'];
                }
                if (isset($datosColeccion['dibujo']) && (!isset($datosColeccion['guion']) || $datosColeccion['dibujo'] != $datosColeccion['guion'])) {
                    $autor[] = $datosColeccion['dibujo'];
                }
                $coleccion->autor = !empty($autor) ? implode(', ', $autor) : null;
                $coleccion->save();
                //fwrite($fp, "Coleccion: ".$coleccion->titulo." Autor: ".$coleccion->autor."\r\n");
                //fclose($fp);
            }
        }
        catch (\Exception $e){
            //guardar el resultado en un log
//            fclose($fp);
//            $fp = fopen(storage_path('logs/resultado_autores.txt'), 'w');
//            fwrite($fp, $e->getMessage());
//            fclose($fp);
            dd($e->getMessage());
        }
    }

    public static function procesarListadoColecciones($log = true){
        try{
            DB::beginTransaction();
            $nombreLog = date('d-m-Y')."_logListadoColecciones.txt";
            if($log){
                $fp = fopen(storage_path('logs/'.$nombreLog), 'w');
                fwrite($fp, date('d/m/Y H:i:s')."======================================================INICIO PROCESO DE EXTRACCIÓN DE DATOS\r\n");
            }
            $datos = self::extraerDatosListadoColecciones();
            foreach ($datos as $dato){
                //imprimimos el atributo href
                $url = explode('=',$dato->getAttribute('href'));
                $id = $url[count($url)-1];
                //Si la incial es un signo de puntuacion entonces cogemos la siguiente letra. Si no es una letra se guarda en #
                ListadoColeccion::firstOrCreate(
                    [
                        'coleccion_id' => $id
                    ],
                    [
                    'coleccion_id' => $id,
                    //inicial del nombre, si la inicial no es una letra se guarda en #
                    'inicial' => preg_match('/[a-zA-Z]/', $dato->text()[0]) ? strtoupper($dato->text()[0]) : '#',
                    'nombre' => $dato->text()
                ]);
            }
            if($log){
                fwrite($fp, date('d/m/Y H:i:s')."======================================================FIN PROCESO DE EXTRACCIÓN DE DATOS\r\n");
                fclose($fp);
            }
            DB::commit();
        }
        catch (\Exception $e){
            fwrite($fp, date('d/m/Y H:i:s')."======================================================ERROR: ".$e->getMessage()."\r\n");
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public static function extraerDatosListadoColecciones(){
        $url = 'https://www.listadomanga.es/lista.php';
        $datos = ColeccionHelper::culr($url);
        //Configuramos el objeto Dom para que acepte UTF-8
        $dom_datos = new Dom();
        try{
            $dom_datos->loadStr($datos);
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
        $etiqueta = " td.izq a";
        $datos = $dom_datos->find($etiqueta);
        return $datos;
    }
}
