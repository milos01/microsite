<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Website;
use Auth;

class WebsiteController extends Controller
{
    public function newWebsite(Request $request){
    	$this->validate($request, [
                'companyName' => 'required|max:255',
                'websiteTitle' => 'required|max:255',
                'domain' => 'required|max:255',
        ]);

        $website = new Website();
        $website->company_name = $request->companyName;
        $website->title = $request->websiteTitle;
        $website->domain = $request->domain;
        $website->active = 0;
        $website->user_id = Auth::id();
        $website->theme_id = $request->theme_id;
        $website->expire_at = $now->addMonth();

        if($website->save() && $user->save()){
        	return response($website, 200);
        }
    }
}
