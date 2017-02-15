<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
	/**
     * Get the theme record associated with the website.
     */
    public function theme()
    {
        return $this->hasOne('App\Theme');
    }
}
