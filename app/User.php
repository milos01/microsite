<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'role_id', 'email', 'password',
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
     * Check users role
     */
    public function hasRole($role)
    {
            if (  $this->role->name == $role)
            {
                return true;
            }
        return false;
    }

    /**
     * The roles that belong to the user.
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
}
