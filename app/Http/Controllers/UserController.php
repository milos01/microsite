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

    /**
     * Update logged user info.
     *
     * @return \Illuminate\Http\Response!!!!!!!!!!!!
     */
    public function updateInfo(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
    	if($request->email){
    		$user = User::find(Auth::id());
    		$user->email = $request->email;
    		$user->save();
    		// return back();
    	}

    }
}
