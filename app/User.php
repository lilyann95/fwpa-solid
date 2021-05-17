<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'fwpnumber', 
        'email', 
        'password',
        'image', 
        'userType',
        'status'
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

    public function expense() {
        return $this->hasMany("App\Expenses");
    }

    public function savings()
    {
        return $this->hasMany("App\Savings");
    }
    public function loans()
    {
        return $this->hasMany("App\Loans");
    }
    public function guarantors()
    {
        return $this->hasMany("App\Guarantors");
    }
}
