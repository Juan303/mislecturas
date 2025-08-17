@extends('layouts.app')

@section('body-class', 'sidebar-collapse')

@section('navigation')
    @include('partials.navigations.navigation')
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="main main-section pb-5">
        <div class="container pt-2">
            <div class="row">
                <div class="col-lg-10 ml-auto mr-auto article">
                    <h2 class="title text-dark">{{ __('footer.cookies') }}</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-md-10 ml-auto mr-auto article">
                    <p>{!! $web_text->text !!}</p>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <a href="{{ route('welcome') }}" class="btn btn-vzero">{{ __('buttons.Volver') }}</a>
            </div>
        </div>
    </div>
@endsection
