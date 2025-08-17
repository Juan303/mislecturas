<div class="js-cookie-consent" style="position:fixed; display: block; min-height: 100vh; width: 100%; background-color: rgba(0,0,0,0.8); z-index: -1000; overflow: hidden;"></div>
<div class="js-cookie-consent cookie-consent" style="z-index: 10050; height: 25vh; bottom:0; top:auto; position: fixed">


    <p class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
    </p><br>

    <button class="js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookieConsent::texts.agree') }}
    </button>
    <button class="js-cookie-consent-cancel cookie-consent__agree">
        {{ trans('cookieConsent::texts.cancel') }}
    </button>

</div>

<div class="modal fade" id="modal-cookies" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10070;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-uppercase" id="exampleModalLabel">{{ __('footer.cookies') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $cookieText->text !!}
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-vzero close" data-dismiss="modal">{{ __('buttons.Cerrar') }}</button>
            </div>
        </div>
    </div>
</div>
