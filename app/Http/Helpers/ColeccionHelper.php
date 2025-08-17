<?php
namespace App\Http\Helpers;

use App\Coleccion;
use App\Comic;
use App\UsuarioLectura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;
use Illuminate\Support\Facades\DB as BD;

class ColeccionHelper{


    public const ITEMS_POR_PAGINA = 20;
    public static function extraerDatosColeccionListadoManga($id, $actualizacion, Request $request = null){
        if(!$actualizacion) {
            $datos = self::procesarDatosColeccion($id, null, false, $request);
            if (!empty($datos['coleccion'])) {
                return $datos;
            }
        }

        $url = 'https://www.listadomanga.es/coleccion.php?id='.$id;
        $datos = self::culr($url);

        $dom_datos = new Dom();
        try{
            $dom_datos->loadStr($datos);
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
        $etiquetasDatos = "";
        for ($i=1; $i<30; $i++){
            $etiquetasDatos .= " .ventana_id".$i." tr, ";
        }
        $etiquetasMangas = " body > center ";
        $datos = $dom_datos->find($etiquetasDatos);
        $mangas = $dom_datos->find($etiquetasMangas);

        //Datos de la coleccion
        if(!isset($datos[0])){
            return false;
        }
        $datosColeccion['titulo'] = trim(html_entity_decode($datos[0]->find('h2')->innerHtml));
        $data = explode('<br />', html_entity_decode($datos[0]->innerHtml));
        foreach($data as $linea){

            if(strpos($linea, 'Título original') !== false){
                $temp = explode('>', $linea);
                $key = "tituloOriginal";
            }
            elseif(strpos($linea, 'Guion')){
                $temp = explode('>', $linea);
                $key = "guion";
            }
            elseif(strpos($linea, 'Dibujo')){
                $temp = explode('>', $linea);
                $key = "dibujo";
            }
            elseif(strpos($linea, 'Autores')){
                $temp = explode('>', $linea);
                $key = "autores";
            }
            elseif(strpos($linea, 'Historia original')){
                $temp = explode('>', $linea);
                $key = "historiaOriginal";
            }
            elseif(strpos($linea, 'Traducción')){
                $temp = explode('>', $linea);
                $key = "traduccion";
            }
            elseif(strpos($linea, 'Editorial japonesa')){
                $temp = explode('>', $linea);
                $key = "editorialJaponesa";
            }
            elseif(strpos($linea, 'Editorial española')){
                $temp = explode('>', $linea);
                $key = "editorialEspanola";
            }
            elseif(strpos($linea, 'Colección')){
                $temp = explode('>', $linea);
                $key = "tipo";
            }
            elseif(strpos($linea, 'Formato')){
                $temp = explode('>', $linea);
                $key = "formato";
            }
            elseif(strpos($linea, 'Sentido')){
                $temp = explode('>', $linea);
                $key = "sentido";
            }
            elseif(strpos($linea, 'japonés')){
                $temp = explode('>', $linea);
                $key = "numerosJapones";
            }
            elseif(strpos($linea, 'español') || strpos($linea, 'castellano')){
                $temp = explode('>', $linea);
                $datosColeccion['completa'] = true;
                if(strpos(html_entity_decode($linea), 'incompleta') || strpos(html_entity_decode($linea), 'abierta')){
                    $datosColeccion['completa'] = false;
                }
                $key = "numerosEspanol";
            }

            if(!empty($temp[count($temp)-1])){
                $datosColeccion[$key] = strip_tags(trim($temp[count($temp)-1]));

            }
            elseif(!empty($temp[count($temp)-2])){
                $datosColeccion[$key] = strip_tags(trim($temp[count($temp)-2]));
                if(empty( $datosColeccion[$key])){
                    $temp = explode("</a>", $linea);
                    $temp = explode('>', $temp[0]);
                    $datosColeccion[$key] = $temp[count($temp)-1];
                }
            }
        }

        //Datos de los mangas de la coleccion
        $listadosManga = $mangas[0]->find("center > table");
        $cont = 0;
        $listadoMangas = [];
        $textoSinopsis = '';
        $cont1 = 1;
        foreach($listadosManga as $listado){
            if((strpos(html_entity_decode($listado->innerHtml), '>Números editados<') || strpos(html_entity_decode($listado->innerHtml), '>Números editados (')) && !strpos(html_entity_decode($listado->innerHtml), '(Packs)')){
                $mangasEditados = (!empty($listadosManga[$cont+1]))?$listadosManga[$cont+1]->find('.cen'):[];
                foreach($mangasEditados as $manga){
                    $listadoMangas[] = self::procesarDatosManga($manga, $id, $cont1, 'editado',true);
                    $cont1++;
                }
            }
            elseif(strpos(html_entity_decode($listado->innerHtml), '>Números en preparación<')){
                $mangasEnPreparacion = (!empty($listadosManga[$cont+1]))?$listadosManga[$cont+1]->find('.cen'):[];
                //$cont1 = 1;
                foreach($mangasEnPreparacion as $manga){
                    $listadoMangas[] = self::procesarDatosManga($manga, $id, $cont1, 'preparacion',true);
                    $cont1++;
                }
            }
            elseif(strpos(html_entity_decode($listado->innerHtml), '>Números no editados<')){
                $mangasNoEditados = (!empty($listadosManga[$cont+1]))?$listadosManga[$cont+1]->find('.cen'):[];
                foreach($mangasNoEditados as $manga){
                    $listadoMangas[] = self::procesarDatosManga($manga, $id, $cont1, 'no_editado',true);
                    $cont1++;
                }
            }
            elseif(strpos(html_entity_decode($listado->innerHtml), '>Números editados (Ediciones Especiales)<')){
                $mangasEditadosEspeciales = (!empty($listadosManga[$cont+1]))?$listadosManga[$cont+1]->find('.cen'):[];
                foreach($mangasEditadosEspeciales as $manga){
                    $listadoMangas[] = self::procesarDatosManga($manga, $id, $cont1, 'edicion_especial',true);
                    $cont1++;
                }
            }
            elseif(strpos(html_entity_decode($listado->innerHtml), '>Sinopsis')){
                $sinopsis = (!empty($listado))?$listado->find('.izq'):[];
                if(!empty($sinopsis)) {
                    $sinopsis = explode('<br />', $sinopsis);
                    $sinopsis[0] = explode('<hr />', $sinopsis[0])[1];
                    foreach ($sinopsis as $parrafo){
                        if(!empty($parrafo) && $parrafo != ' '){
                            $textoSinopsis .= '<p>'.strip_tags($parrafo).'</p>';
                        }
                    }
                }
            }
            $cont++;
        }
        $datos = [
            'datosColeccion' => $datosColeccion,
            'listadoMangas' => $listadoMangas,
            'sinopsis' => $textoSinopsis
        ];

        //Guardamos los datos de una coleccion cada vez que entramos en ella
        return self::procesarDatosColeccion($id, $datos, true, $request);

    }


    private static function guardarDatos($id, $datos){
        try {

            Storage::deleteDirectory('images/comics/' . $id);
            BD::beginTransaction();
            //==================Guardamos la coleccion
            $autor = [];
            if(isset($datos['datosColeccion']['guion'])) {
                $autor[] = $datos['datosColeccion']['guion'];
            }
            //Agregamos el dibujo si este es distinto al guion
            if(isset($datos['datosColeccion']['dibujo'])){
                $autor[] = $datos['datosColeccion']['dibujo'];
            }
            else if(isset($datos['datosColeccion']['autores'])){
                $autor[] = $datos['datosColeccion']['autores'];
            }

            $coleccion = Coleccion::updateOrCreate([
                'id' => $id
            ],
                [
                    'id' => $id,
                    'autor' => implode(', ', $autor),
                    'datosColeccion' => $datos['datosColeccion'],
                    'titulo' => $datos['datosColeccion']['titulo'],
                    'tituloOriginal' => (isset($datos['datosColeccion']['tituloOriginal'])) ? $datos['datosColeccion']['tituloOriginal'] : '-',
                    'sinopsis' => $datos['sinopsis'],
                    'completa' => $datos['datosColeccion']['completa']
                ]);
            $coleccion->touch(); //actualizamos el campo "updated_at" aunque no haya cambios

            //Borrar los comics que no estén en la lista
            Comic::where('coleccion_id', '=', $id)
                ->whereNotIn('numero', array_column($datos['listadoMangas'], 'numero'))
                ->delete();
            //===================Guardamos los comics
            foreach ($datos['listadoMangas'] as $comic) {
                $comic['imagen'] = '/storage/' . self::guardarImagen($comic, $id);
                Comic::updateOrCreate(
                    [
                        'numero' => $comic['numero'],
                        'coleccion_id' => $comic['coleccion_id'],
                    ], $comic);
            }
            BD::commit();
        }
        catch (\Exception $e){
            BD::rollBack();
        }
    }

    //Funcion principal para extraer toda la información posible de cada coleccion.

    private static function procesarDatosColeccion($id, $datos = null, $actualizar = false, $request){
        if($actualizar && !empty($datos)){
            self::guardarDatos($id, $datos);
        }
        $coleccion = Coleccion::where('colecciones.id', $id)->first();
        $comics = Comic::where('coleccion_id', '=', $id)
            ->leftjoin('usuario_comics as uc', function ($q) {
                $q->on('uc.comic_id', '=', 'comics.id');
                if (auth()->user()) {
                    $q->where('uc.user_id', '=', auth()->user()->id);
                }
            })
            ->leftjoin('usuario_lecturas as ul', function ($q) {
                $q->on('comics.id', '=', 'ul.comic_id');
                if (auth()->user()) {
                    $q->where('ul.user_id', '=', auth()->user()->id);
                }
            })
            ->leftjoin('colecciones', 'colecciones.id', '=', 'comics.coleccion_id')
            ->leftjoin('prestamos as pr', function ($q) {
                $q->on('pr.item_id', '=', 'comics.id');
                $q->where('pr.tipo', '=', 'comic');
                if(auth()->user()){
                    $q->where('pr.usuario_id', '=', auth()->user()->id);
                }
            })
            ->select([
                DB::raw("'manga' as tipoLectura"), //para que coincida con la tabla "lecturas
                'comics.*',
                'colecciones.titulo as tituloColeccion',
                'colecciones.datosColeccion',
                DB::raw("IF(uc.tengo IS NULL, 0, uc.tengo) as tengo"),
                DB::raw("IF(ul.estado_lectura IS NULL, 0, ul.estado_lectura) as estado_lectura"),
                'ul.paginas_totales',
                'ul.paginas_leidas',
                'ul.fecha_inicio_lectura',
                'ul.fecha_fin_lectura',
                'pr.persona as prestamo_persona',
                'pr.direccion as prestamo_direccion',
                'pr.created_at as prestamo_fecha'
            ]);

        if ($request != null && $request->isMethod('post')) {
            $comics = self::filtrar($request, $comics);
        }
        $comics = $comics->orderBy('comics.id')->paginate(self::ITEMS_POR_PAGINA);
        $comics_publicados = Comic::where('coleccion_id', '=', $id)->where('tipo', '=', 'editado')->count();

        return ['coleccion' => $coleccion, 'comics' => $comics, 'comics_publicados' => $comics_publicados];

    }

    //Filtrar comics en una coleccion
    private static function filtrar(Request $request, $comics){
        if (!empty($request->post('posesion'))){
            if($request->post('posesion') == 'item-tengo'){
                $comics->where('uc.user_id', '=', auth()->user()->id)
                    ->where('uc.tengo', '=', UsuarioComicHelper::TENGO);
            }
            elseif($request->post('posesion') == 'item-quiero'){
                $comics->where('uc.user_id', '=', auth()->user()->id)
                    ->where('uc.tengo', '=', UsuarioComicHelper::QUIERO);
            }
            else{
                $comics->whereNull('uc.tengo')->orWhere('uc.tengo', '=', UsuarioComicHelper::QUIERO);
            }
        }
        if (!empty($request->post('lectura'))){
            if($request->post('lectura') == 'item-leyendo'){
                $comics->where('ul.user_id', '=', auth()->user()->id)
                    ->where('ul.estado_lectura', '=', LecturaHelper::ESTADO_LEYENDO);
            }
            elseif($request->post('lectura') == 'item-leido'){
                $comics->where('ul.user_id', '=', auth()->user()->id)
                    ->where('ul.estado_lectura', '=', LecturaHelper::ESTADO_LEIDO);
            }
            elseif($request->post('lectura') == 'item-quiero-leer'){
                $comics->where('ul.user_id', '=', auth()->user()->id)
                    ->where('ul.estado_lectura', '=', LecturaHelper::ESTADO_QUIERO_LEER);
            }
            else{
                $comics->whereNull('ul.estado_lectura');
            }
        }
        if (!empty($request->post('tipo'))){
            $comics->where(function($h) use ($request){
                if($request->post('tipo') == 'item-editado'){
                    $h->orWhere('comics.tipo', 'LIKE', 'editado');
                }
                if($request->post('tipo') == 'item-en-preparacion'){
                    $h->orWhere('comics.tipo', 'LIKE', 'preparacion');
                }
                if($request->post('tipo') == 'item-no-editado'){
                    $h->orWhere('comics.tipo', 'LIKE', 'no_editado');
                }
            });
        }
        if(!empty(trim($request->post('buscar')))){
            $buscar = explode(' ', $request->post('buscar'));
            foreach($buscar as $termino){
                $comics->where(function($q) use ($termino){
                    $q->orWhere('colecciones.titulo', 'LIKE', '%'.$termino.'%');
                    $q->orWhere('comics.numero', 'LIKE', '%'.$termino.'%');
                });
            }
        }
        return $comics;
    }

    /* Proceso los datos de cada manga que se encuentra en una coleccion de "listadoManga" */
    /* */

    private static function procesarDatosManga($manga, $id, $cont, $editado, $fecha = null){
        $datos = explode('<br />', $manga->innerHtml);
        $imagen = $manga->find('img')->getAttribute('src');
        $imagen_dividida = explode('.', $imagen);
        if($imagen_dividida[count($imagen_dividida)-1] == 'png'){ //si la imagen es .png es que es la imagen censurada y necesitamos el atributo data-portada
            $imagen = 'https://static.listadomanga.com/'.$manga->find('img')->getAttribute('data-portada');
        }


        $numero = $numeroPaginasBN = $numeroPaginasColor = $bn = $precio = $moneda = '';
        foreach($datos as $linea){
            if(strpos(html_entity_decode($linea), 'nº')){
                $numero = self::extraerNumeroComic($linea);
            }
            if(strpos(html_entity_decode($linea), 'en B/N')){
                $numeroPaginasBN = self::extraerNumeroPaginasBNComic($linea);
            }
            if(strpos(html_entity_decode($linea), 'a color')){
                $numeroPaginasColor = self::extraerNumeroPaginasColorComic($linea);
            }
            if(strpos(html_entity_decode($linea), '€')){
                $precio = self::extraerPrecioComic($linea);
                $moneda = '€';
            }
            if(strpos(html_entity_decode($linea), 'Ptas.')){
                $precio = self::extraerPrecioComic($linea);
                $moneda = 'Ptas.';
            }
            if(strpos(html_entity_decode($linea), '$')){
                $precio = self::extraerPrecioComic($linea);
                $moneda = '$';
            }
        }
        return [
            'numero' =>  (empty($numero))?$cont:$numero,
            'numeroUnico' => (empty($numero))?1:0,
            'coleccion_id' => intval($id),
            'numeroPaginasBN' => intval($numeroPaginasBN),
            'numeroPaginasColor' => intval($numeroPaginasColor),
            'tipo' => $editado,
            'precio' => floatval(str_replace(',', '.', $precio)),
            'moneda' => $moneda,
            'imagen' => $imagen,
            'fecha' => (!empty($fecha))?strip_tags($datos[count($datos)-1]):$fecha
        ];
    }

    /* Función para guardar la imagen de cada comic
    Se le pasan el comic y el id de la coleccion.
    Del comic extraemos la url de la imagen y el idColeccion nos sirve para indicar la carpeta donde tiene que guardarse la imagen
    Devuelve la ruta a la imagen*/

    private static function guardarImagen($comic, $idColeccion){
        $imagen = self::culr($comic['imagen']);
        $fileName = uniqid()."_".$comic['numero'].'.jpg';
        $path = 'images/comics/'.$idColeccion.'/'.$fileName;
        Storage::disk('public')->put($path, $imagen);
        return $path;
    }

    //=============Funciones para extraer los datos de los comics del HTML
    private static function extraerNumeroComic($datos){
        $temp = explode("nº", html_entity_decode($datos));
        if(empty($temp[1])){
            return 1;
        }
        return $temp[1];
    }
    private static function extraerNumeroPaginasBNComic($datos){
        $temp = explode(" páginas", html_entity_decode($datos));
        return $temp[0];
    }
    private static function extraerNumeroPaginasColorComic($datos){
        $temp = explode(" páginas", html_entity_decode($datos));
        return $temp[0];
    }
    private static function extraerPrecioComic($datos){
        if(strpos(html_entity_decode($datos), '€')){
            $temp = explode("€", html_entity_decode($datos));
        }
        elseif(strpos(html_entity_decode($datos), 'Ptas.')){
            $temp = explode("Ptas.", html_entity_decode($datos));
        }
        elseif(strpos(html_entity_decode($datos), '$')){
            $temp = explode("$", html_entity_decode($datos));
            return trim($temp[1]);
        }
        return trim($temp[0]);
    }
    //=============Fin funciones para extraer los datos de los comics del HTML
    public static function listadoColecciones(){
        $colecciones = DB::table('listado_colecciones_vista AS lcv')->select(
            'lcv.*'
            ,DB::raw('CASE WHEN uc.coleccion_id IS NULL THEN 0 ELSE 1 END AS coleccionando')
            ,'ucom.nComics'
            ,'c.nComicsEditados'
            ,DB::raw('CASE
                        WHEN ucom.nComics IS NOT NULL AND ucom.nComics > 0 AND ucom.nComics = c.nComicsEditados THEN "completa"
                        WHEN ucom.nComics IS NOT NULL AND ucom.nComics > 0 AND ucom.nComics < c.nComicsEditados THEN "incompleta" END AS estado'))
            ->leftJoin('usuario_colecciones AS uc', function($join){
                $join->on('uc.coleccion_id', '=', 'lcv.id');
                $join->where('uc.user_id', '=', auth()->user()->id);
            })
            ->leftJoin('colecciones AS col', 'col.id', '=', 'lcv.id')
            //unimos con usuarios comics para ver cuantos comics tiene el usuario de esa coleccion. Para ellos haremos un join con un select que nos devuelva el numero de comics que tiene el usuario de esa coleccion
            ->leftJoin(DB::raw('(SELECT usuario_coleccion_id, COUNT(*) AS nComics FROM usuario_comics WHERE user_id = '.auth()->user()->id.' AND tengo = 1 GROUP BY usuario_coleccion_id) AS ucom'), 'ucom.usuario_coleccion_id', '=', 'uc.id')
            ->leftJoin(DB::raw("(SELECT coleccion_id, COUNT(*) AS nComicsEditados FROM comics WHERE tipo = 'editado' GROUP BY coleccion_id) AS c"), 'c.coleccion_id', '=', 'col.id');
        return $colecciones->get();
    }

    //Funcion para actualizar el numero de paginas de los comics no editados. Estos deben tener un numero de paginas igual a la media de los comics editas de la coleccion
    public static function actualizarPaginasNoEditados(){
        //cogemos solo colecciones que esten en las tablas de usuario_colecciones
        $colecciones = Coleccion::whereIn('id', function($query){
            $query->select('coleccion_id')
                ->from('usuario_colecciones');
        })->get();
        foreach($colecciones as $coleccion){
            $comicsEditados = Comic::where('coleccion_id', '=', $coleccion->id)
                ->where('tipo', '=', 'editado')
                ->get();
            if($comicsEditados->count() > 0){
                $mediaPaginasBN = $comicsEditados->avg('numeroPaginasBN');
                $mediaPaginasColor = $comicsEditados->avg('numeroPaginasColor');
                Comic::where('coleccion_id', '=', $coleccion->id)
                    ->where('tipo', '=', 'no_editado')
                    ->update([
                        'numeroPaginasBN' => $mediaPaginasBN,
                        'numeroPaginasColor' => $mediaPaginasColor
                    ]);
            }
        }
    }

    //Funcion para actualizar las lecturas de un usuario usuario_lecturas y el historico de lecturas
    public static function actualizarLecturasMangasLeidos(){
        //NEcesito hacer un
        DB::statement("
            UPDATE usuario_lecturas ul
            JOIN comics c ON ul.comic_id = c.id
            SET ul.paginas_totales = (c.numeroPaginasBN + c.numeroPaginasColor),
                ul.paginas_leidas = CASE
                    WHEN ul.estado_lectura = ".LecturaHelper::ESTADO_LEIDO." THEN (c.numeroPaginasBN + c.numeroPaginasColor)
                    ELSE ul.paginas_leidas
                END
            WHERE c.tipo IN ('editado', 'preparacion');");


        DB::statement("
            UPDATE historico_lecturas hl
            JOIN (
                SELECT MAX(hl2.id) AS id
                FROM historico_lecturas hl2
                JOIN usuario_lecturas ul2 ON hl2.user_id = ul2.user_id AND hl2.comic_id = ul2.comic_id
                WHERE ul2.paginas_leidas = ul2.paginas_totales
                GROUP BY hl2.user_id, hl2.comic_id
            ) ultimos ON hl.id = ultimos.id
            JOIN comics c ON hl.comic_id = c.id
            JOIN usuario_lecturas ul ON ul.comic_id = c.id AND ul.user_id = hl.user_id
            SET hl.paginasLeidas = (c.numeroPaginasBN + c.numeroPaginasColor)
            WHERE c.tipo IN ('editado', 'preparacion') AND ul.estado_lectura = ".LecturaHelper::ESTADO_LEIDO.";");

    }


    //Funcion curl para extraer los html de la url objetivo
    public static function culr($url){
        $ch = curl_init($url); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //Charset UTF-8
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=UTF-8'));
        //curl_setopt($ch,CURLOPT_USERAGENT,"User-Agent: Mozilla/5.0");
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:133.0) Gecko/20100101 Firefox/133.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        if($info == false){
            return curl_error($ch);
        }
        curl_close($ch); // Cierra sesión cURL

        return $info; // Devuelve la información de la función
    }


}

?>
