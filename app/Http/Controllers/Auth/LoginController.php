<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
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




    use AuthenticatesUsers;

    //Reescribimos la funcion que hace el login de tal manera que pueden llegar por GET el mail y el pass para que se haga login automatico
    //Habria que hacer el login con el email y la contraseña que se envian por GET
    public function login()
    {
        if (request()->has('email') && request()->has('password')) {
            $credentials = request(['email', 'password']);
            if (auth()->attempt($credentials)) {
                return redirect()->intended($this->redirectTo());
            }
        }
        return view('auth.login');
    }



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
