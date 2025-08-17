<div class="position-relative">
<div class="progress-new-bar my-0 text-center" id="{{ !empty($id) ? $id : '' }}">
    <div class="progress-new"
         data-percent="{{ $porcentaje > 100 ? 100 : $porcentaje }}"
         data-color="{{ $porcentaje >= 100 ? 'green' : 'orange' }}">
    </div>
</div>
<div class="progress-new-text">
    <span class="px-2">{{ $porcentaje > 100 ? 100 : $porcentaje }}%</span>
</div>
</div>