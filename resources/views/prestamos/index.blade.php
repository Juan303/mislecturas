@extends('items_comun.index')

@section("styles")
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.uikit.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" />
    <style>
        .nav-link.active{
            background-color: #3d923d !important;
        }
        .scrolling-wrapper {
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection

@section('zona-items')
    <div class="row @movile @else mt-5 @endmovile">
        <div class="col col-md-2 text-nowrap text-start  align-items-baseline">
            <span class="@movile h5 @else h3 @endmovile text-uppercase text-muted">Préstamos</span>
        </div>
        <div class="col-md-12">
            <hr class="border-top text-muted">
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 border-1 rounded mb-3">
            <h4 class="text-center">
                <i class="fas fa-arrow-up"></i>
                Libros/comics que he prestado
            </h4>
            <table id="tablaPrestamosHechos" class="table table-sm table-bordered small">
                <thead>
                    <tr>
                        <th data-sortable="true" data-field="fecha" data-formatter="fechaFormatter">Fecha</th>
                        <th data-sortable="true" data-field="titulo">Título</th>
                        <th data-sortable="true" data-field="persona">Persona</th>
                        <th class="text-center" data-formatter="tablaPrestamosHechosFormatterActionsRow">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-12 col-md-6 border-1 rounded">
            <h4 class="text-center">
                <i class="fas fa-arrow-down"></i>
                Libros/comics que me han prestado
            </h4>
            <table id="tablaPrestamosRecibidos" class="table table-sm table-bordered small">
                <thead>
                    <tr>
                    <th data-sortable="true" data-field="fecha" data-formatter="fechaFormatter">Fecha</th>
                        <th data-sortable="true" data-field="titulo">Título</th>
                        <th data-sortable="true" data-field="persona">Persona</th>
                        <th class="text-center" data-formatter="tablaPrestamosRecibidosFormatterActionsRow">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section("scripts")
    {{--<!-- Prestamos -->--}}
    <script src="{{ asset('js/prestamos/prestamos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/prestamos/prestamosFormatter.js') }}" type="text/javascript"></script>
    {{--<!-- Carga perezosa de imagenes -->--}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
@endsection


@section("modals")
   
@endsection



