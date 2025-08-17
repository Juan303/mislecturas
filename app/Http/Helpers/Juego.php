<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Estilo;

class Juego{

   public static function listaJuegos(Request $request){
       if(!empty($request->get('sistema_id'))){
           $juegos = auth()->user()->sistemas()->find($request->get('sistema_id'))->juegos()->where('user_id', '=', auth()->user()->id)->with('estilos', 'listas');
       }
       elseif(!empty($request->get('lista_id'))){
           $juegos = auth()->user()->listas()->find($request->get('lista_id'))->juegos()->where('user_id', '=', auth()->user()->id)->with('estilos', 'listas');
       }
       elseif(!empty($request->get('estilo_id'))){
           $juegos = Estilo::find($request->get('estilo_id'))->juegos()->where('user_id', auth()->user()->id)->with('estilos', 'listas');
       }
       else{
           $juegos = auth()->user()->juegos()->with('estilos', 'listas');
       }

       if(!empty($request->get('tipo')) && $request->get('tipo') === 'quiero'){
           $juegos->quiero();
       }
       else{
           $juegos->tengo();
       }
       return $juegos->orderBy('id', 'DESC')->get();
   }

   public static function generarDataTable(Collection $juegos){
       return DataTables::of($juegos)
           ->addColumn('estilos', function($row){
               $res = "";
               foreach ($row->estilos as $key => $estilo){
                   $res .= "<a href='".route('juego.estilo.index', ['estilo' => $estilo->id])."'><span class='badge badge-info ml-1'>".$estilo->nombre."</span></a>";
               }
               return $res;
           })
           ->addColumn('imagen', function($row){
               $res = "<div class=\"lightgallery mr-2\">";
               $cont = 0;
               foreach ($row->images as $image){
                   $display = "";
                   if($cont !== 0){
                       $display = "d-none";
                   }
                   $res .= "<div class=\"img-gallery ".$display."\" data-src=\"".asset($image->make_url($row->id))."\">
                                <a href=\"\"><img src=\"".asset($image->make_thumbnail_url($row->id))."\" class=\"img-fluid w-100 mr-4 mb-2 mt-2\" alt=\"\"></a>
                            </div>";
                   $cont++;
               }
               $res .= "</div>";
               return $res;
           })
           ->addColumn('accion', function($row){
               $res = "<a href=\"".route('juego.edit', ['juego' => $row->id])."\"  title=\"". __('Editar datos')."\" class=\"btn btn-link px-1 text-success px-0 my-0 py-0\"><i class=\"fa fa-edit\"></i></a>";
               $res .= "<a href=\"".route ('juego_images.index', ['juego'=>$row->id])."\" title=\"Editar imagenes\" class=\"btn btn-link px-1 text-warning px-0 my-0 py-0\"><i class=\"fa fa-image\"></i></a>";
               $res .= "<button type=\"button\"  data-item-id=\"". $row->id ."\" data-item-name=\"".$row->nombre."\"  title=\"¿". __('Eliminar') ."?\" class=\"btn btn-delete px-1 btn-link text-danger my-0 py-0\"><i class=\"fa fa-times\"></i></button>";

               if(!empty($row->descripcion)){
                   $res .= "<button type=\"button\" data-item-id=\"". $row->id ."\"  title=\"Notas\" class=\"btn btn-notas btn-link px-1 btn-link text-info my-0 py-0\"><i class=\"fa fa-file-text-o\"></i></button><br>";
               }
               $res .= "<button type=\"button\"  data-item-id=\"". $row->id ."\"   title=\"¿". __('Agregar a lista') ."?\" class=\"btn btn-agregar px-1 btn-success my-0 py-0\">Añadir a lista</button><br>";
               return preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
           })
           ->addColumn('precioCompra', function($row){
               return ($row->precioCompra)?$row->precioCompra."€":'';
           })
           ->addColumn('puntuacion', function ($row){
               return self::mostrarPuntuacion($row);
           })
           ->addColumn('listas', function($row){
               $res = "";
               foreach ($row->listas as $key => $lista){
                   $res .= "<div class=\"btn-group m-0 mr-1\">
                              <a href=\"".route('juego.lista.index', ['lista_id' => $lista->id])."\" class=\"btn btn-warning p-0 px-2 m-0 btn-sm\">".$lista->nombre."</a>
                              <button type=\"button\" data-item-id=\"". $row->id ."\" data-item-nombre=\"". $row->nombre ."\" data-lista-id=\"". $lista->id ."\" data-lista-nombre=\"". $lista->nombre ."\" title=\"¿". __('Eliminar de la lista') ."?\" class=\"btn btn-warning btn-delete-lista p-0 px-2 m-0 btn-sm rounded-right\" >
                                <i class=\"fas fa-times\"></i>
                              </button>
                            </div>";
               }
               return $res;
           })
           ->editColumn('fechaAdquisicion', function ($row) {
               //mostramos la fecha en un span oculto delante de la fecha ya formateada para que la ordenacion por columna salga bien
               return $row->fechaAdquisicion ? "<span class='d-none'>".$row->fechaAdquisicion."</span>".with(new Carbon($row->fechaAdquisicion))->format('d/m/Y') : '';
           })

           ->rawColumns(['imagen', 'estilos','listas', 'accion', 'fechaAdquisicion', 'puntuacion'])
           ->make(true);
   }

   private static function mostrarPuntuacion($row){
       switch ($row->puntuacion){
           case 1:
           case 2:
               return "<span class='badge badge-danger h6'>".$row->puntuacion."</span>";
               break;
           case 3:
           case 4:
               return "<span class='badge badge-warning h6'>".$row->puntuacion."</span>";
               break;
           default:
               return "<span class='badge badge-success h6'>".$row->puntuacion."</span>";
       }
   }
}

?>
