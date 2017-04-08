<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Website;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Helpers\UserHelper as Usr;

class WebsiteController extends Controller
{
    use Usr;
    /**
     * Create new website.
     *
     * @return \Illuminate\Http\Response
     */
    public function newWebsite(Request $request){
    	$this->validate($request, [
            'companyName' => 'required|max:255',
            'websiteTitle' => 'required|max:255',
            'domain' => 'required|max:255',
            ]);
        $now = Carbon::now();

        $website = new Website();
        $website->company_name = $request->companyName;
        $website->title = $request->websiteTitle;
        $website->domain = $request->domain;
        $website->active = 0;
        $website->user_id = $this->loggedUserId();
        $website->theme_id = $request->theme_id;
        $website->expire_at = $now->addMonth();

        $website->save();
        return response($website, 200);
    }

    /**
     * Soft delete website.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteWebsite($id){
        $website = Website::findorFail($id);
        $website->delete();
        return back();
    }
}
