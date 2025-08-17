<div class="col-6 col-md-4 col-xl-3 d-flex align-items-stretch">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row justify-content-center">
                <h6 class="text-muted text-uppercase text-center">
                    {{ $lectura->tituloColeccion }}
                </h6>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <img src="{{ $lectura->imagen }}" alt="{{ $lectura->tituloColeccion }}" class="img-fluid">
                </div>
<!--                <div class="col-md-6">
                    <p class="text-uppercase small text-muted">
                        {{ $lectura->tituloColeccion }}
                    </p>
                </div>-->
            </div>
        </div>
    </div>
</div>
