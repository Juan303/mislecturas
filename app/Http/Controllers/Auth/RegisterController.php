<?php

namespace App\Http\Controllers\Auth;


use App\Lista;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /* public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $success = true;
        try{
            $this->registered($request, $user);
        }
        catch (\Exception $e){
            $success = $e->getMessage();
        }
        if($success){
            $mensaje = "Usuario registrado correctamente.</br>Le hemos enviado un mail con el enlace de activación a la cuenta de correo indicada en el registro Porfavor acceda a dicho enlace para activar la cuenta.</br> Gracias.";
            session()->flash('message', ['type' => 'success', 'text'=>$mensaje]);
        }
        else{
            session()->flash('message', ['type' => 'warning', 'text'=>$success]);
        }
        return redirect(route('login'));

    }*/

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us_action')]
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $success = true;
        try {
            DB::beginTransaction();
            $usuario = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'active' => 1,
                'email_verified_at' => time()
            ]);
        }
        catch (\Exception $e){
            DB::rollBack();
            $success = $e->getMessage();
        }

        if($success === true){
            DB::commit();
            return $usuario;
        }

    }
}
