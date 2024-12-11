<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;


class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    protected $fillable = [
        'name', 'lastname', 'email', 'phone_number', 'username', 'password', 'profile_picture',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // app/Models/User.php

    public function attendingEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user')->withPivot('created_at');
    }

    // Esto es importante para autenticar usando el correo y la contraseña
    //public function setPasswordAttribute($value)
    //{
        //$this->attributes['password'] = bcrypt($value);  // Esto no es necesario si ya usas Hash::make
    //}

}

