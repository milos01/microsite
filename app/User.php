<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'role_id', 'email', 'phone', 'password', 'trial_ends_at',
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'trial_ends_at'];
    
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

    /**
     * Get the websites for the user.
     */
    public function websites()
    {
        return $this->hasMany('App\Website');
    }
}
