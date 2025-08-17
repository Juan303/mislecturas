<div class="card rounded mt-0">
    <div class="card-body pb-0 @movile px-2 @endmovile">
        <div class="row mb-2">
            <div class="col-10">
                <div class="@movile h5 @else h4 @endmovile text-uppercase text-muted mb-0 @movile mt-0 @endmovile">
                    Últimas lecturas activas
                </div>
            </div>
            <div class="col-2 text-right">
                @movile
                <a href="{{ route('usuario.lectura.index', ['estado' => 'leyendo']) }}" class="py-0 px-2 mb-0">
                    <i class="text-info fas fa-book"></i>
                </a>
                @else
                    <a href="{{ route('usuario.lectura.index', ['estado' => 'leyendo']) }}" class="btn btn-sm btn-outline-info float-right">Ver todas</a>
                    @endmovile
            </div>
            <div class="col-12">
                <hr class="border-top m-0">
            </div>
        </div>
        <div class="row p-2">
            @foreach($lecturasEnCurso as $lectura)
                @include('partials.cards.comic_card', ['manga'=>$lectura, 'zona'=> 'welcome', 'elementosPorFila' => 3])
            @endforeach
        </div>
    </div>
</div>