<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;

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
        return view('homeCenter');
    }

    public function showEditTemplate(){
        return view('modals.editUserModal');
    }

    public function showNewSitePage(){
        $themes = Theme::all();
        return view('newsite')->with('themes', $themes);
    }

}
