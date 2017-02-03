<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
	/**
	 * Show profile page from logged user
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function profile()
    {
        return view('profile');
    }

    /**
	 * Deactivate logged user
	 *
	 * @return Illuminate\Routing\Redirector
	 */
    public function deactivateUser()
    {
    	User::findorFail(Auth::id())->delete();
    	return redirect()->route('login');
    }
}
