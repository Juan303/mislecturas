<div class="col-12">
    <div class="card rounded mt-0">
        <div class="card-body @movile px-2 @endmovile ">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="@movile h5 @else h4 @endmovile text-uppercase text-muted mb-0 @movile mt-0 @endmovile">DATOS DE INTERÉS ({{ date('Y') }})</div>
                </div>
                <div class="col-12">
                    <hr class="border-top m-0">
                </div>
            </div>
            <div class="row">
                <!-- ritmo de lectura que debes llevar al mes para cumplir el reto -->
                <div class="col-12">
                    <ul class="list-unstyled m-1">
                        <li class="text-muted mb-1">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Total libros leidos en {{ date('Y') }}: <strong class="text-dark">{{ $totalLibrosLeidos }}</strong>
                        </li>
                        <li class="text-muted mb-1">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Páginas leidas en {{ date('Y') }}: <strong class="text-dark">{{ number_format($totalPaginasLeidas, 0, ',', '.') }}</strong>
                        </li>
                        <li class="text-muted mb-1">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Páginas leidas al día en {{ date('Y') }}: <strong class="text-dark">{{ number_format($totalPaginasLeidasDia, 0, ',', '.') }}</strong>
                        </li>
                        <li class="text-muted mb-1">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Lees una media de <strong class="text-dark">{{ $mediaLibrosLeidosPorDia }}</strong> libros al <strong class="text-dark">día.</strong>
                        </li>
                        <li class="text-muted mb-1">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Lees una media de <strong class="text-dark">{{ $mediaLibrosLeidosPorSemana }}</strong> libros a la <strong class="text-dark">semana.</strong>
                        </li>
                        <li class="text-muted mb-1">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Lees una media de <strong class="text-dark">{{ $mediaLibrosLeidosPorMes }}</strong> libros al <strong class="text-dark">mes.</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>