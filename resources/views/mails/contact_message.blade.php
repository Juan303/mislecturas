@component('mail::message')
# MENSAJE

## Nombre: {{ $name }}
## Correo electrónico: {{ $email }}
## Empresa / Universidad: {{ $enterprise }}


{{ $text }}

{{ __("Gracias") }},<br>
{{ config('app.name') }}

@endcomponent