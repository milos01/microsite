<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
	protected $table = 'websites';
    protected $fillable = ['theme_id', 'user_id', 'company_name', 'title', 'domain', 'active'];

    protected $hidden = [];
	/**
     * Get the theme record associated with the website.
     */
    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }
}
