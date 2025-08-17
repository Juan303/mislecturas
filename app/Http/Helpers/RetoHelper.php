<?php
namespace App\Http\Helpers;



use App\Reto;
use Illuminate\Support\Facades\DB;


class RetoHelper{

    //Libros que tengo que leer al mes para completar el reto. Teniendo en cuenta el mes actual y los libros que tengo leidos hasta la fecha
    public static function librosAlMesParaCompletaReto($anyo){
        $reto = DB::table('retos_vista')->where('anyoReto', $anyo)->where('user_id', auth()->user()->id)->first();
        if($reto == null){
            return 0;
        }
        $librosLeidos = $reto->nLecturas;
        $librosRestantes = $reto->cantidadAnual - $librosLeidos;
        //si estamos en diciembre, el numero de libros que me quedan por leer es librosRestantes
        if(date('n') == 12){
            return $librosRestantes < 0 ? 0 : $librosRestantes;
        }
        //Si no estamos en diciembre, calculamos los meses restantes hasta diciembre y el numero de libros que me quedan por leer
        $mesesRestantes = 12 - (date('n') - 1);
        $res = round($librosRestantes / $mesesRestantes, 2);
        return $res < 0 ? 0 : $res;
    }

    //Libros que tengo que leer a la semana para completar el reto. Teniendo en cuenta el mes actual y los libros que tengo leidas hasta la fecha
    public static function librosALaSemanaParaCompletarReto($anyo){
        $reto = DB::table('retos_vista')->where('anyoReto', $anyo)->where('user_id', auth()->user()->id)->first();
        if($reto == null){
            return 0;
        }
        $librosLeidos = $reto->nLecturas;
        $librosRestantes = $reto->cantidadAnual - $librosLeidos;
        //si estamos en la ultima semana del año, el numero de paginas que me quedan por leer es librosRestantes
        if(date('n') == 12 && date('W') == 52){
            return $librosRestantes < 0 ? 0 : $librosRestantes;
        }
        //Si no estamos en la ultima semana del año, calculamos las semanas restantes hasta la ultima semana del año y el numero de libros que me quedan por leer
        $semanasRestantes = 52 - (date('W')-1);
        $res = round($librosRestantes / $semanasRestantes, 2);
        return $res < 0 ? 0 : $res;
    }
}

?>
