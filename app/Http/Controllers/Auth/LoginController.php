<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    //Palabra clave para decodificar la pass que podria llegar por GET
    public $clave = '1234567890abcdef';
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function index(){

        if(auth()->user()){
            return view('welcome');
        }
        if (request()->has('email') && request()->has('password')) {
            $credentials = request(['email', 'password']);
            if (auth()->attempt($credentials)) {
                return redirect()->intended($this->redirectTo());
            }
        }
        //dd('No se ha podido autenticar el usuario. Por favor, compruebe sus credenciales.');
        return view('auth.login');
        /*$business_areas = BusinessArea::active(true)->orderBy('weight')->get();
        $family_products = FamilyProduct::active(true)->orderBy('weight')->get();
        $news = News::active(true)->orderBy('created_at', 'DESC')->take(3)->get();
        $services = Service::active(true)->orderBy('weight')->get();

        return view('welcome')->with(compact('business_areas', 'family_products', 'news', 'services', 'texto_portada'));*/
    }
    public function redirectTo()
    {
        return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
    }

    //Reescribimos la funcion que muestra la pagina de login de tal manera que pueden llegar por GET el mail y el pass para que se haga login automatico
    public function showLoginForm()
    {
        if (request()->has('hash')) {
            // La pass llega encriptada, por lo que la desencriptamos (AES-256-CBC) y la clave es '1234567890abcdef'
            $getData = base64_decode(request('hash'));
            $email = explode('=',explode('&', $getData)[0])[1]; // Obtenemos el email
            $password = explode('=',explode('&', $getData)[1])[1]; // Obtenemos la contraseña

            $credentials = [
                'email' => $email, // Obtenemos el email de la URL,
                'password' => $password // Obtenemos la contraseña de la URL
            ];
            if (auth()->attempt($credentials)) {
                return redirect()->intended($this->redirectTo());
            }
        }
        return view('auth.login');
    }


    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        Session::put('backUrl', URL::previous());
    }
}
