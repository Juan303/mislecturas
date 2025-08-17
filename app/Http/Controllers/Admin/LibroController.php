<?php

namespace App\Http\Controllers\Admin;

use App\Coleccion;
use App\Comic;
use App\HistoricoLectura;
use App\Http\Helpers\HistoricoLecturaHelper;
use App\Http\Helpers\LecturaHelper;
use App\Http\Helpers\LibroHelper;
use App\Http\Helpers\UsuarioComicHelper;
use App\Libro;
use App\Sistema;
use App\UsuarioLectura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Helpers\ColeccionHelper;
use Illuminate\Support\Facades\Session;
use PHPHtmlParser\Dom;
use stringEncode\Exception;
use function Sodium\crypto_auth;
use Illuminate\Support\Facades\Storage;
//usar la libreria Str para hacer el slug
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class LibroController extends Controller
{

    //======================================Muestra las colecciones de un usuario
    public function index(Request $request){
        $objLibros = Libro::where('user_id', auth()->user()->id);
        $libros = $objLibros;
        if(request()->isMethod('post')){
            $libros = LibroHelper::filtrar($request, $objLibros);
        }
        $libros = $libros
            ->orderBy('created_at', 'desc')
            ->paginate(LibroHelper::ITEMS_POR_PAGINA);
        return view('libros.index')->with(compact('libros', 'request'));
    }

    //CRUD
    //Create
    public function create(){
        return view('libros.crear');
    }

    //Store
    public function store(Request $request){
        try {
            DB::beginTransaction();
            $estado_lectura = 0;
            if (($request->input('paginas_leidas') == $request->input('paginas_totales')) || !empty($request->input('fecha_fin_lectura'))) {
                $estado_lectura = 2;
            }
            else if ($request->input('paginas_leidas') > 0 || !empty($request->input('fecha_inicio_lectura'))) {
                $estado_lectura = 1;
            }

            $tengo = ($request->input('precio_compra') != null || $request->input('fecha_compra') != null)?UsuarioComicHelper::TENGO:UsuarioComicHelper::NO_TENGO;
            $fecha_compra = ($request->input('precio_compra') != null)?($request->input('fecha_compra') == null)?now():$request->input('fecha_compra'):null;
            $libro = Libro::create([
                'titulo' => $request->input('titulo'),
                'titulo_original' => $request->input('titulo_original'),
                'autor' => $request->input('autor'),
                'editorial' => $request->input('editorial'),
                'paginas_totales' => $request->input('paginas_totales'),
                'paginas_leidas' => ($request->input('paginas_leidas') == '') ? 0 : $request->input('paginas_leidas'),
                'fecha_inicio_lectura' => ($request->input('paginas_leidas') != '') ? now() : $request->input('fecha_inicio_lectura'),
                'fecha_fin_lectura' => $request->input('fecha_fin_lectura') != '' ? $request->input('fecha_fin_lectura') : (($request->input('paginas_leidas') == $request->input('paginas_totales')) ? now() : null),
                'fecha_compra' => $fecha_compra,
                'tengo' => $tengo,
                'precio_compra' => $request->input('precio_compra'),
                'estado_lectura' => $estado_lectura,
                'sinopsis' => $request->input('sinopsis'),
                'puntuacion' => $request->input('puntuacion'),
                'isbn13' => $request->input('isbn'),
                'user_id' => auth()->user()->id,
                'read_updated_at' => now()
            ]);

            //Registramos las lecturas
            if(($request->input('paginas_leidas') != '')) {
                HistoricoLecturaHelper::guardarRegistro($libro->id, null, $request->input('paginas_leidas'));
            }
            else{
                HistoricoLecturaHelper::borrarRegistros($libro->id, null);
            }


            //Imagen temporal de internet
            if(!empty($request->input('urlImagenTemporal'))){
                //Descargamos la imagen mediante curl
                $fileName = uniqid();
                $ch = curl_init($request->input('urlImagenTemporal'));
                $fp = fopen(public_path('img/'.$fileName.'.jpg'), 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                //Guardamos la imagen
                $intervention = new ImageManager(['driver' => 'gd']);
                $image = $intervention->make(public_path('img/'.$fileName.'.jpg'))->encode();
                $path = 'images/libros/'.$libro->id;
                Storage::disk('public')->put($path.'/'.$fileName.".jpg", $image);
                $libro->imagen = '/storage/'.$path.'/'.$fileName.".jpg";
                $libro->save();
                //Borramos la imagen temporal
                Storage::delete('img/'.$fileName.'.jpg');
            }



            DB::commit();
            session()->flash('message', ['type' => 'success', 'text' => 'Libro creado correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('message', ['type' => 'success', 'text' => 'Error al crear el libro ('.$e->getMessage().')']);
        }
        return redirect()->route('usuario.libros.index');
    }

    public function edit(Libro $libro){
        return view('libros.editar')->with(compact('libro'));
    }

    public function update(Libro $libro, Request $request){
        try {
            DB::beginTransaction();
            $estado_lectura = 0;
            if (($request->input('paginas_leidas') == $request->input('paginas_totales')) || !empty($request->input('fecha_fin_lectura'))) {
                $estado_lectura = 2;
            }
            else if ($request->input('paginas_leidas') > 0 || !empty($request->input('fecha_inicio_lectura'))) {
                $estado_lectura = 1;
            }
            $tengo = ($request->input('precio_compra') != null || $request->input('fecha_compra') != null)?UsuarioComicHelper::TENGO:UsuarioComicHelper::NO_TENGO;
            $libro->update([
                'titulo' => $request->input('titulo'),
                'titulo_original' => $request->input('titulo_original'),
                'autor' => $request->input('autor'),
                'editorial' => $request->input('editorial'),
                'paginas_totales' => $request->input('paginas_totales'),
                'paginas_leidas' => ($request->input('paginas_leidas') == '') ? 0 : $request->input('paginas_leidas'),
                'fecha_inicio_lectura' => ($libro->fecha_inicio_lectura == null && $request->input('paginas_leidas') != null) ? now() : $request->input('fecha_inicio_lectura'),
                //'fecha_fin_lectura' => $request->input('fecha_fin_lectura') != '' ? $request->input('fecha_fin_lectura') : ($request->input('paginas_leidas') == $request->input('paginas_totales')) ? now() : null,
                'fecha_fin_lectura' => $request->input('fecha_fin_lectura') != '' ? $request->input('fecha_fin_lectura') : (($request->input('paginas_leidas') == $request->input('paginas_totales')) ? now() : null),
                'fecha_compra' => $request->input('fecha_compra'),
                'tengo' => $tengo,
                'precio_compra' => $request->input('precio_compra'),
                'estado_lectura' => $libro->estado_lectura,
                'sinopsis' => $request->input('sinopsis'),
                'puntuacion' => $request->input('puntuacion'),
                'isbn13' => $request->input('isbn'),
                'user_id' => auth()->user()->id,
                'read_updated_at' => ($libro->estado_lectura != $estado_lectura)?now():$libro->read_updated_at
            ]);

            //Registramos las lecturas
            if(($request->input('paginas_leidas') != '')) {
                HistoricoLecturaHelper::guardarRegistro($libro->id, null, $request->input('paginas_leidas'), $request->input('fecha_fin_lectura'));
            }
            else{
                HistoricoLecturaHelper::borrarRegistros($libro->id, null);
            }

            //Imagen temporal
            if(!empty($request->input('urlImagenTemporal'))){
                //Descargamos la imagen mediante curl
                $fileName = uniqid();
                $ch = curl_init($request->input('urlImagenTemporal'));
                $fp = fopen(public_path('img/'.$fileName.'.jpg'), 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                //Borrar la imagen anterior
                Storage::deleteDirectory('images/libros/'.$libro->id);
                //Guardamos la imagen
                $intervention = new ImageManager(['driver' => 'gd']);
                $image = $intervention->make(public_path('img/'.$fileName.'.jpg'))->encode();
                $path = 'images/libros/'.$libro->id;
                Storage::disk('public')->put($path.'/'.$fileName.".jpg", $image);
                $libro->imagen = '/storage/'.$path.'/'.$fileName.".jpg";
                $libro->save();
            }


            //Imagen
            if ($request->hasFile('imagen')) {
                //Borramos la imagen anterior (borramos la carpeta entera)
                Storage::deleteDirectory('images/libros/'.$libro->id);
                $imagen = $request->file('imagen');
                $nombreImagen = $imagen->hashName();
                $path = 'images/libros/'.$libro->id;
                $imagen->storeAs($path, $nombreImagen,'public');
                $libro->imagen = '/storage/'.$path.'/'.$nombreImagen;
                $libro->save();
            }

            DB::commit();
            session()->flash('message', ['type' => 'success', 'text' => 'Libro actualizado correctamente']);
        }
        catch (\Exception $e) {
            DB::rollBack();
            session()->flash('message', ['type' => 'success', 'text' => 'Error al actualizar el libro (' . $e->getMessage() . ')']);
        }
        return redirect()->route('usuario.libros.index');
    }

    public function destroy(Libro $libro){
        try {
            DB::beginTransaction();
            $libro->delete();
            DB::commit();
            session()->flash('message', ['type' => 'success', 'text' => 'Libro eliminado correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('message', ['type' => 'success', 'text' => 'Error al eliminar el libro ('.$e->getMessage().')']);
        }
        return redirect()->route('usuario.libros.index');
    }

    public function cambiarEstado(Request $request){
        $IdLibro = $request->post('IdLibro');
        $accion = $request->post('accion');
        $libro = Libro::find($IdLibro);
        try {
            DB::beginTransaction();
            switch ($accion){
                case 'leyendo':
                    $libro->update([
                        'estado_lectura' => LecturaHelper::ESTADO_LEYENDO,
                        'fecha_inicio_lectura' => now(),
                        'fecha_fin_lectura' => null,
                        'read_updated_at' => now(),
                    ]);
                    HistoricoLecturaHelper::guardarRegistro($libro->id, null, $libro->paginas_leidas);
                    break;
                case 'leido':
                    $libro->update([
                        'estado_lectura' => LecturaHelper::ESTADO_LEIDO,
                        'fecha_fin_lectura' => now(),
                        'paginas_leidas' => $libro->paginas_totales,
                        'read_updated_at' => now(),
                    ]);
                    HistoricoLecturaHelper::guardarRegistro($libro->id, null, $libro->paginas_totales);
                    break;
                case 'quiero leer':
                    $libro->update([
                        'estado_lectura' => LecturaHelper::ESTADO_QUIERO_LEER,
                        'fecha_fin_lectura' => null,
                        'paginas_leidas' => 0,
                        'fecha_inicio_lectura' => null,
                        'fecha_quiero_leer' => now(),
                        'read_updated_at' => now(),
                    ]);
                    HistoricoLecturaHelper::borrarRegistros($libro->id, null);
                    break;
                case 'no leido':
                    $libro->update([
                        'estado_lectura' => LecturaHelper::ESTADO_NO_LEIDO,
                        'fecha_fin_lectura' => null,
                        'paginas_leidas' => 0,
                        'fecha_inicio_lectura' => null,
                        'fecha_quiero_leer' => null,
                        'read_updated_at' => now(),
                    ]);
                    HistoricoLecturaHelper::borrarRegistros($libro->id, null);
                    break;
            }
            DB::commit();
            return Response::json([
                'accion' => $accion,
                'type' => 'alert-success',
                'message' => "Se ha cambiado el estado de la lectura correctamente",
                'idLibro' => $IdLibro,
                'idComic' => $IdLibro,
                'datosLectura' => $libro]);

        }
        catch (\Exception $e){
            DB::rollBack();
            return Response::json([
                'accion' => $accion,
                'type' => 'alert-danger',
                'message' => $e->getMessage(),
                'idLibro' => $IdLibro,
                'idComic' => $IdLibro,
                'datosLectura' => $libro]);
        }
    }

    public function cambiarPaginasLeidas(Request $request){
        return LecturaHelper::cambiarPaginasLeidas($request, 'libro');
    }

    public function historicoLecturas(Libro $libro){
        return LecturaHelper::historicoLecturas($libro->id, 'libro');
    }

    //==========================================AUTOCOMPLETE ONLINE
    public function getListadoLibrosAutocomplete(Request $request){
        try {
            $buscar = $request->buscar;
            $buscar = str_replace(" ", "+", $buscar);
            $url = "https://www.googleapis.com/books/v1/volumes?q=".$buscar;
            //$url = "https://www.goodreads.com/book/auto_complete?format=json&q=".$buscar;
            //$url = "https://api.empathy.co/search/v1/query/cdl/search?internal=true&query=".$buscar."&origin=query_suggestion%3Apredictive_layer&start=0&rows=24&instance=cdl&lang=es&scope=desktop&store=ES&isSPA=true";
            //$url = "https://www.googleapis.com/books/v1/volumes?q=".$buscar."&key=" . env('GOOGLE_BOOKS_API_KEY');
            $datos = self::culr($url);
            return $datos;
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function getDatosLibro(Request $request){

        //$url = "https://www.goodreads.com/".$request->url1;
        //dd('https://www.casadellibro.com/libro-cuentos-inconclusos-ilustrada-por-alee-jhowetnasmith-revisa-da/9788445013625/13477636', $url);
        $datos = self::culr($request->url);


       /* //$images = self::culr($url.'/boxes');
        $dom_datos = new Dom();
        //$dom_images = new Dom();
        try{
            $dom_datos = $dom_datos->loadStr($datos);
            //$dom_images->loadStr($images);
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
        $res = self::tratarDatosLibro($dom_datos);*/
        //return $res;
        return $datos;

    }

    private function tratarDatosLibro($datos, $images = null){
        //dd($datos);
        $res = [];
        //print_r($datos);
        //Buscamos la etiqueta con data-testid="bookTitle" para obtener el nombre del libro
        $res["Nombre"] = (!empty($datos->find('.Text__title1')[0])?trim($datos->find('.Text__title1')[0]->text):'');
        //$res["Autor"] = (!empty($datos->find('.author span')[0])?ucwords(strtolower(trim($datos->find('.author span')[0]->text))):'');
        $res["Sinopsis"] =  (!empty($datos->find('.BookPageMetadataSection__description .Formatted')[0])?trim($datos->find('.BookPageMetadataSection__description .Formatted')[0]->innerHtml):'');

        //$ficha = $datos->find('.DescListItem');
        $ficha = [];
        $res['n_datos'] = $datos->find('.CollapsableList')->innerHtml;
        foreach($ficha as $dato) {
           /* if ($dato->find('dt')->text == 'ISBN'){
                $res['isbn'] = trim($dato->find('dd')->text);
            }
            else if ($dato->find('dt')->text == 'Published'){
                //Tengo: "August 23, 2018 by Norma Editorial". Necesito extraer la fecha en formato dd/mm/aaaa
                $fecha = explode(' by ', trim($dato->find('dd')->text))[0];
                $fecha = explode(' ', $fecha);
                $mes = trim($fecha[0]);
                $dia = trim(str_replace(',', '', $fecha[1]));
                $anio = trim($fecha[2]);
                //Convertimos el mes a numero con alguna libreria
                $mes = date('m', strtotime($mes));
                $res['fecha_publicacion'] = $dia . '/' . $mes . '/' . $anio;
            }*/
            if ($dato->find('dt')->text == 'Format'){
                $res['formato'] = trim($dato->find('dd')->text);
                $res['no_de_paginas'] = explode(' ', trim($dato->find('dd .TruncatedContent__text')->text))[0];
            }
        }

        //$siglasPlataforma = ($siglasPlataforma == 'NS')?'switch':strtolower($siglasPlataforma);
       /* foreach ($images as $image){
            if(strpos($image->getAttribute('href'), $siglasPlataforma)!==false && strpos($image->find('img')->getAttribute('alt'), 'EU')!==false){
                $res['images'][] = [
                    'url' => 'https://gamefaqs.gamespot.com' . $image->getAttribute('href'),
                    'src' => 'https://gamefaqs.gamespot.com' . $image->find('img')->getAttribute('src')
                ];
            }
        }

        foreach ($temp as $key => $item){
            if(strpos($key, 'Release')!== false){
                $res['Release'] = date('Y-m-d',strtotime($item));
            }
            elseif (strpos($key, 'Developer/Publisher')!== false){
                $res['Developer'] = $item;
                $res['Publisher'] = $item;
            }
            else{
                $res[str_replace(':', '', $key)] = $item;
            }
        }*/
        return $res;
    }

    private function culr($url){
        $ch = curl_init($url); // Inicia sesión cURL
        //devolvera un json con los datos de la url
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //curl_setopt($ch,CURLOPT_USERAGENT,"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15");

        //Seguir redirecciones
        //curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        if($info == false){
            return curl_error($ch);
        }
        curl_close($ch); // Cierra sesión cURL

        return $info; // Devuelve la información de la función
    }
}
