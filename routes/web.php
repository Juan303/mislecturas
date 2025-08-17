<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Ruta para poder cambiar de idioma y regresar a la misma pagina que se estaba
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

//Rutas para el login/logout, registro y recuperación de contraseña
Auth::routes(['verify' => true]);


//============================================================================================COLECCIONES (Sin login)
Route::group(['prefix' => 'colecciones',  'namespace' => 'Admin'], function() {
    Route::get('/listadoColecciones', 'ColeccionController@listadoColecciones')->name('coleccion.listadoColecciones');
    Route::get('/loadListadoColecciones', 'ColeccionController@loadListadoColecciones')->name('coleccion.loadListadoColecciones');
    Route::get('/coleccion/{id}', 'ColeccionController@coleccion')->name('coleccion.index');
    // Ruta para recabar el listado segun una busqueda
    Route::get('/autocomplete/buscar', 'ColeccionController@getListadoColeccionListadoManga')->name('coleccion.autocomplete.listado');
    //Ruta a la que ir cuando se selecciona una coleccion del listado
    Route::get('/datosColeccion', 'ColeccionController@getDatosColeccionListadoManga')->name('coleccion.autocomplete.datosColeccion');

});

Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::get('/', 'WelcomeController@index')->name('welcome');
});


//============================================================================================RUTAS QUE NECESITAN LOGIN
Route::group(['middleware' => ['auth', 'verified'], 'namespace' => 'Admin'], function(){

    //============================================================================================HOME
    Route::group(['prefix' => 'home'], function(){
        Route::get('', 'HomeController@index')->name('home');
        Route::put('/store', 'HomeController@update')->name('home.update');
    });
    //============================================================================================LIBROS
    Route::group(['prefix' => 'libros'], function() {
        Route::any('/', 'LibroController@index')->name('usuario.libros.index');
        Route::get('/create', 'LibroController@create')->name('usuario.libros.create');
        Route::post('/store', 'LibroController@store')->name('usuario.libros.store');
        Route::get('/edit/{libro}', 'LibroController@edit')->name('usuario.libros.edit');
        Route::put('/update/{libro}', 'LibroController@update')->name('usuario.libros.update');
        //Cambiar paginas leidas
        Route::post('/cambiar-paginas-leidas', 'LibroController@cambiarPaginasLeidas')->name('usuario.libros.cambiarPaginasLeidas');
        //Historico de lectura
        Route::get('/historico-lecturas/{libro}', 'LibroController@historicoLecturas')->name('usuario.libros.historico-lecturas');
        //Destroy
        Route::delete('/destroy/{libro}', 'LibroController@destroy')->name('usuario.libros.destroy');
        Route::post('/cambiar-estado', 'LibroController@cambiarEstado')->name('usuario.libros.cambiarEstado');
        //Buscar libros online
        Route::get('/autocomplete', 'LibroController@getListadoLibrosAutocomplete')->name('usuario.libros.autocomplete'); //Mostrar listado a partir de la BD
        Route::get('/autocomplete/getDatosLibro', 'LibroController@getDatosLibro')->name('usuario.libros.datosLibro'); //Tomar los datos del juego de gamefaqs y rellenar los campos
    });
    //============================================================================================COLECCIONES
    Route::group(['prefix' => 'colecciones'], function() {
        Route::get('/', 'ColeccionController@index')->name('usuario.colecciones.index');
        Route::get('/prevision-compras', 'ColeccionController@previsionCompras')->name('usuario.colecciones.prevision-compras');
        Route::post('/coleccion/{id}', 'ColeccionController@coleccion')->name('coleccion.index');
        Route::delete('/destroy/{id}', 'ColeccionController@destroy')->name('usuario.coleccion.destroy');
    });

    //============================================================================================COMICS
    Route::group(['prefix' => 'comics'], function() {
        Route::post('/store', 'ComicController@store')->name('comic.store');
        Route::post('/store/seleccion', 'ComicController@storeSeleccion')->name('comic.store.seleccion');
        Route::post('/store/favoritos', 'ComicController@favoritosStoreSeleccion')->name('comic.store.favoritos.seleccion');
        Route::post('/delete/favoritos', 'ComicController@favoritosDeleteSeleccion')->name('comic.delete.favoritos.seleccion');
        Route::post('/delete/seleccion', 'ComicController@deleteSeleccion')->name('comic.delete.seleccion');
    });
    //============================================================================================LECTURAS
    Route::group(['prefix' => 'lecturas'], function() {
        Route::get('/{estado?}', 'LecturaController@index')
            ->where(['estado' => 'leidos|leyendo|quiero-leer'])
            ->name('usuario.lectura.index');
        Route::post('/{estado?}', 'LecturaController@index')
            ->where(['estado' => 'leidos|leyendo|no-leidos|quiero-leer'])
            ->name('usuario.lectura.index');
        Route::post('/store', 'LecturaController@store')->name('lectura.store');
        Route::post('/store/seleccion', 'LecturaController@storeSeleccion')->name('lectura.store.seleccion');
        Route::delete('/delete/seleccion', 'LecturaController@deleteSeleccion')->name('lectura.delete.seleccion');

        //Cambiar paginas leidas
        Route::post('/cambiar-paginas-leidas/{tipoLectura}', 'LecturaController@cambiarPaginasLeidas')->name('lectura.cambiarPaginasLeidas');
        //Historico de lectura
        Route::get('/historico-lecturas/{libro}/{tipoLectura}', 'LecturaController@historicoLecturas')->name('lectura.historico-lecturas');
        //Datos de una lectura
        Route::get('/datos-lectura/{id}/{tipoLectura}', 'LecturaController@datosLectura')->name('lectura.datos-lectura');

        //Ultimas lecturas
        Route::get('/ultimas-lecturas', 'LecturaController@ultimasLecturas')->name('usuario.lectura.ultimas-lecturas');

        //RETOS
        Route::get('/retos', 'LecturaController@retos')->name('usuario.lectura.retos');
        Route::put('/retos/storeReto', 'LecturaController@storeReto')->name('usuario.lectura.retos.store');
        Route::get('/retos/loadRetoActual/{zona?}', 'LecturaController@loadRetoActual')->name('usuario.lectura.retos.loadRetoActual');

        //RESUMEN
        Route::get('/resumen', 'LecturaController@resumen')->name('usuario.resumen.index');
        Route::post('/loadResumen', 'LecturaController@loadResumen')->name('usuario.resumen.loadResumen');
    });

    //============================================================================================ESTADISTICAS
    Route::group(['prefix' => 'estadisticas'], function() {
        Route::get('/', 'EstadisticasController@index')->name('usuario.estadisticas');
        Route::get('/loadDatosInteres', 'EstadisticasController@loadDatosInteres')->name('usuario.estadisticas.loadDatosInteres');
        Route::post('/loadEstadisticasAnualesLectura', 'EstadisticasController@loadEstadisticasAnualesLectura')->name('usuario.estadisticas.loadEstadisticasAnualesLectura');

    });

    //============================================================================================PRESTAMOS
    Route::group(['prefix' => 'prestamos'], function() {
        Route::get('/prestamos', 'PrestamoController@index')->name('usuario.prestamos.index');
        Route::get('/listarPrestamos/{direccion}', 'PrestamoController@listarPrestamos')->name('usuario.prestamos.listarPrestamos');
        Route::post('/asignarPrestamo', 'PrestamoController@asignarPrestamo')->name('usuario.prestamos.asignarPrestamo');
        Route::post('/devolverPrestamo', 'PrestamoController@devolverPrestamo')->name('usuario.prestamos.devolverPrestamo');
    });

    //============================================================================================RETOS
    //Retos de lectura
    Route::group(['prefix' => 'retos'], function() {
        Route::get('/', 'RetoController@index')->name('retos.index');
        Route::put('/store', 'RetoController@store')->name('retos.store');
    });
    //============================================================================================BUSCADOS
    Route::group(['prefix' => 'buscados'], function() {
        Route::get('/', 'BuscadosController@index')->name('usuario.buscados.index');
        Route::post('/', 'BuscadosController@index')->name('usuario.buscados.index');
    });
});
//============================================================================================FIN RUTAS QUE NECESITAN LOGIN


//Scrapper para descargar la informacion de la web "listadoManga"
Route::get('/scrapper/{ncolecciones?}', 'ScrapperController@extraerListadoManga')->name("scrapper");
Route::get('/scrapper-listado', 'ScrapperController@procesarListadoColecciones')->name("scrapper-listado");
Route::get('/scrapper-procesar-autores', 'ScrapperController@procesarAutores')->name("procesar-autores");
Route::get('/scrapper-full', 'ScrapperController@extraerListadoMangaEntero')->name("scrapper-full");




