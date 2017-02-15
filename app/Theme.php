<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';
    protected $fillable = ['theme_id', 'name', 'price', 'pictuire', 'description'];

    protected $hidden = [];

    /**
     * Get the user that owns the website.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
