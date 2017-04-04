<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use SoftDeletes;

	protected $table = 'websites';
    protected $fillable = ['theme_id', 'user_id', 'company_name', 'title', 'domain', 'active', 'expire_at'];

    protected $hidden = [];
    protected $dates = ['expire_at', 'deleted_at'];
	/**
     * Get the theme record associated with the website.
     */
    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
