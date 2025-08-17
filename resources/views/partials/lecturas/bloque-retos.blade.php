<div class="row">
    <div class="col-12">
        <div class="progress-new-bar mt-1 mb-1" id="progressBarProgresoAnual">
            <div class="progress-new text-center"
                 data-percent="{{ $retoAnyoActual->CantidadAnual > 0 ? round((count($librosAnyoActual) / $retoAnyoActual->CantidadAnual) * 100, 2) : 0 }}"
                 data-color="green">
                <span>{{ $retoAnyoActual->CantidadAnual > 0 ? round((count($librosAnyoActual) / $retoAnyoActual->CantidadAnual) * 100, 2) : 0 }}%</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- ritmo de lectura que debes llevar al mes para cumplir el reto -->
    <div class="col-12">
        <p class="text-muted mb-0">Para cumplir el reto debes leer:</p>
        <ul class="list-unstyled m-1">
            <li class="text-muted mb-1">
                <i class="fas fa-book"></i>
                <strong class="text-dark" id="librosAlMesParaCumplirReto">
                    {{ round(($retoAnyoActual->CantidadAnual - count($librosAnyoActual)) / (12 - date("m")), 1) }}
                </strong> libros al <strong class="text-dark">mes.</strong>
            </li>
            <li class="text-muted mb-1">
                <i class="fas fa-book"></i>
                <strong class="text-dark" id="librosAlMesParaCumplirReto">
                    {{ round(($retoAnyoActual->CantidadAnual - count($librosAnyoActual)) / (52 - date("W")), 1) }}
                </strong> libros cada <strong class="text-dark">semana.</strong>
            </li>
        </ul>
    </div>
</div>