<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\User;
use Auth;
use Carbon\Carbon;
use App\TokenElement;
use App\Events\DeactivateWebsites;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findorFail(Auth::id());
        $userWebsites = $user->websites()->with('theme')->withTrashed()->orderBy('created_at')->get();
       
        return view('homeCenter')->with('userWebsites', $userWebsites);
    }

    public function showEditTemplate(){
        return view('modals.editUserModal');
    }

    public function showNewSitePage(){
        $themes = Theme::all();
        return view('newsite')->with('themes', $themes);
    }

    public function tokenPaymentPage(){
        $elements = TokenElement::where('user_id', Auth::id())->where('payed', 0)->get();
        if($elements->isEmpty()){
            return redirect('home');
        }
        return view('tokenPayment')->with('elements', $elements)->with('total', count($elements)*5);
    }

    public function showAdminPage(){
        $users = User::where('id','!=',Auth::id())->withTrashed()->get() ;
        return view('admin')->with('users', $users);
    }

}
