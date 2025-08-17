@component('mail::message')
    # MENSAJE

    ## Nombre: {{ $user->email }}
    ## Url: {{ $url }}



    {{ $text }}

    {{ __("Gracias") }},<br>
    {{ config('app.name') }}

@endcomponent
