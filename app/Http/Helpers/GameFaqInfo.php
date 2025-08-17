<?php
namespace App\Http\Helpers;

use PHPHtmlParser\Dom;

class GameFaqInfo{


    public static function culr($url){
        $ch = curl_init($url); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        /* curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);*/
        curl_setopt($ch,CURLOPT_USERAGENT,"User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");

        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        curl_close($ch); // Cierra sesión cURL
        return $info; // Devuelve la información de la función
    }

    public static function tratarDatosJuegoGameFaq(Dom $datos){

        $temp = $res = [];
        foreach($datos as $dato){
            $temp[$dato->find('b')->innerHtml] = $dato->find('a')->innerHtml;
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
        }
        return $res;
    }

}