<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseImageController;
use App\Lista;
use App\ListaImage;

class ListaImageController extends BaseImageController
{
    public function __construct()
    {
        $this->item = new Lista();
        $this->imageItem = new ListaImage();
        $this->tamanyoImagenes = ['alto'=>350, 'ancho'=>500];
        $this->processType = 'fit';
        $this->ruta_volver = 'juego.lista.index';
    }

}
