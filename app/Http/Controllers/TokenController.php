<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function showTokenPage(){
        return view('token');
    }

    public function showElementsPage(){
    	return view('contentElements');
    }
}
