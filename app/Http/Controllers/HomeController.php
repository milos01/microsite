<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\User;
use Auth;
use Carbon\Carbon;

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
        $userWebsites = $user->websites()->with('theme')->where('active', 1)->get();
        $expireInDays = null;
        if($user->trial_ends_at){
            $expireInDays = Carbon::now()->diffInDays($user->trial_ends_at);
        }
       
        return view('homeCenter')->with('userWebsites', $userWebsites)->with('expireInDays', $expireInDays);
    }

    public function showEditTemplate(){
        return view('modals.editUserModal');
    }

    public function showNewSitePage(){
        $themes = Theme::all();
        return view('newsite')->with('themes', $themes);
    }

}
