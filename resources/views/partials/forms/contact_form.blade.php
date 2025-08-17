<div class="col-lg-8 col-md-8 ml-auto mr-auto">
    <div class="card card-login mt-4">
        <form method="POST" id="contact-form" class="contact-form" action="{{ route('contact_message.send') }}" >
            @csrf
            <div class="card-header card-header-primary text-center">
                <h4 class="card-title pb-3">{{ __('navigation.Contacto') }}</h4>
            </div>

            <div class="card-body px-5">
                <div class="form-group">
                    <label for="name" class="bmd-label-floating">{{ __('welcome.Tu nombre') }}...</label>
                    <input required name="name" type="text" id="name" class="form-control">
                    <div id="name_error" class="form-error text-small text-danger mt-0"></div>
                </div>
                <div class="form-group">
                    <label for="email" class="bmd-label-floating">{{ __('welcome.Tu email') }}...</label>
                    <input required name="email" type="email" id="email" class="form-control">
                    <div id="email_error" class="form-error text-small text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="enterprise" class="bmd-label-floating">{{ __('welcome.Empresa o universidad') }}...</label>
                    <input name="enterprise" type="text" id="enterprise" class="form-control">
                </div>
                <div class="form-group">
                    <label for="subject" class="bmd-label-floating">{{ __('welcome.Asunto') }}...</label>
                    <input name="subject" type="text" id="subject" class="form-control">
                </div>
                <div class="form-group">
                    <label for="text" class="bmd-label-floating">{{ __('welcome.Tu mensaje') }}...</label>
                    <textarea required type="text" id="text" name="text" class="form-control" rows="4" ></textarea>
                    <div id="text_error" class="form-error text-small text-danger"></div>
                </div>
                <div class="form-group text-center">
                    <label class="form-check-label" id="privacy-form-check">
                        <input required value="privacy_ok" class="form-check-input" type="checkbox" name="privacy" id="privacy"><a target="_blank" href="{{ route('privacy') }}">{{ __('auth.condiciones') }}</a>
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>

            </div>
            <div class="card-footer text-center justify-content-center">
                <button type="submit" class="btn btn-vzero btn-raised">
                    {{ __('welcome.Enviar mensaje') }}
                </button>
            </div>
        </form>
    </div>
</div>
