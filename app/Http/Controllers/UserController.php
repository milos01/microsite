<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth, Hash;
use App\Events\GraceWebsites;
use App\Events\SubscribeWebsites;
use App\Http\Controllers\Helpers\UserHelper as Usr;

class UserController extends Controller
{
    use Usr;
	/**
	 * Show profile page from logged user.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function profile()
    {
        return view('profile');
    }

    /**
	 * Soft delete user.
	 *
	 * @return Illuminate\Routing\Redirector
	 */
    public function deactivateUser()
    {
    	$this->loggedUser()->delete();
    	return redirect()->route('login');
    }

     /**
     * Get logged user.
     *
     * @return Illuminate\Routing\Redirector
     */
    public function getLoggedUser(){
        return $this->loggedUser();
    }

    /**
     * Update logged user info.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
        $user = $this->loggedUser();
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
                'oldPassword' => 'required|old_password:' . $this->loggedUser()->password,
                'password' => 'required|min:3'
                ],['old_password' => 'It is not your current password.']);

            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response($user, 200);
    }

    /**
     * Changde subscription mode(Yes -> No | No -> Yes).
     *
     * @return User
     */
    public function changeMode(Request $request){
        $user = $this->loggedUser();
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

    /**
     * Deactivate user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userDeactivate($id){
        $user = $this->findUserById($id);
        $user->delete();

        return back();
    }

    /**
     * Activate user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userActivate($id){
        $user = $this->findUserWithTrashed($id);
        $user->deleted_at = null;
        $user->save();

        return back();
    }

    /**
     * Add new user with preset  password and custom role.
     *
     * @return \Illuminate\Http\Response
     */
    public function addneuser(Request $request){
        $this->validate($request, [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|max:255',
            ]);

        return User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'role_id' => $request->role,
            'password' => bcrypt('webueno'),
            ]);
    }

    /**
     * Load all invoices for logged user.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadInvoices(){
        $user = $this->loggedUser();
        $retDict = [];

        if($user->braintree_id){
            $invoices = $user->invoicesIncludingPending();
            
            foreach ($invoices as $key => $invoice) {
                array_push($retDict, [
                    $invoice->date()->toFormattedDateString(),
                    $invoice->invliceStatus(),
                    $invoice->total(),
                    $invoice->id,
                    ]);
            }
        }
        return response($retDict, 200);
    }

    /**
     * Get all user sites.
     *
     * @return \Illuminate\Http\Response
     */
    public function userSites(){
        $user = $this->loggedUser();
        $websites = $user->websites;
        return response($websites, 200);
    }

}
