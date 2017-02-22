<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class BillingController extends Controller
{
	/**
     * Show the billing on users profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function billing(){
    	$user = User::findorFail(Auth::id());
    	$nonactivesites = $user->websites()->with('theme')->get();
    	return view('billing')->with('websites', $nonactivesites); 
    }
}
