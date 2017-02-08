<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth, Hash;

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
     * @return \Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
        $user = User::find(Auth::id());
    	if($request->editType === 'email'){
            $this->validate($request, [
                'email' => 'required|email|max:255|unique:users',
            ]);

    		
    		$user->email = $request->email;
    	}else if($request->editType === 'phone'){
            $this->validate($request, [
                'phone' => 'required|numeric',
            ]);

            $user->phone = $request->phone;
        }else if($request->editType === 'password'){
            $this->validate($request, [
                'oldPassword' => 'required|old_password:' . Auth::user()->password,
                'password' => 'required|min:3'
            ],['old_password' => 'It is not your current password.']);

            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response($user, 200);
    }
}
