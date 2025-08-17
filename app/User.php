<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new Notifications\verifyMailNotification());
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','username', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function usuarioColecciones(){
        return $this->hasMany(UsuarioColeccion::class);
    }

    public function usuarioComics(){
        return $this->hasMany(UsuarioComic::class);
    }

    public function usuariolecturas(){
        return $this->hasMany(UsuarioLectura::class);
    }

    public function usuarioLibros(){
        return $this->hasMany(Libros::class);
    }

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }

    public function reto(){
        return $this->hasOne(Reto::class, 'user_id');
    }

    public function esAdmin(){
        if($this->admin){
            return true;
        }
        return false;
    }
}
