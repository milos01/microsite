<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth, Hash;
use App\Events\GraceWebsites;
use App\Events\SubscribeWebsites;

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

    public function getLoggedUser(){
        return Auth::user();
    }

    /**
     * Update logged user info.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
        $user = User::find(Auth::id());
        if($request->editType === 'user'){
            $this->validate($request, [
                'firstName' => 'required|max:255',
                'lastName' => 'required|max:255',
            ]);

            
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
        }else if($request->editType === 'email'){
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

    public function changeMode(Request $request){
        $user = Auth::user();
        $activesites = $user->websites()->with('theme')->where('active', 1)->get();
        if ($request->val == "yes") {
            event(new SubscribeWebsites($activesites));
            $user->subscribed = 1;
        }else{
            event(new GraceWebsites($activesites));
            $user->subscribed = 0;

        }

        $user->save();
        return $user;
    }
}
