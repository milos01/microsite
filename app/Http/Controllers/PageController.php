<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use App\User;
use Auth;
use App\TokenElement;
use App\Events\DeactivateWebsites;
use App\Http\Controllers\Helpers\UserHelper as Usr;

class PageController extends Controller
{
	use Usr;
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
     * Show applications dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user = $this->loggedUser();
    	$userWebsites = $user->websites()->with('theme')->withTrashed()->orderBy('created_at')->get();

    	return view('homeCenter')->with('userWebsites', $userWebsites);
    }

    /**
     * Show modal for editing user info.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEditTemplate(){
    	return view('modals.editUserModal');
    }

    /**
     * Show page for choosing theme for new website.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNewSitePage(){
    	$themes = Theme::all();
    	return view('newsite')->with('themes', $themes);
    }

    /**
     * Show page for token payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function tokenPaymentPage(){
    	$elements = TokenElement::where('user_id', $this->loggedUserId())->where('payed', 0)->get();
    	if($elements->isEmpty()){
    		return redirect('/');
    	}
    	return view('tokenPayment')->with('elements', $elements)->with('total', count($elements)*5);
    }

    /**
     * Show applications admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminPage(){
    	$users = User::where('id','!=',$this->loggedUserId())->withTrashed()->get() ;
    	return view('admin')->with('users', $users);
    }

    /**
     * Show billing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function billing(){
    	$user = $this->loggedUser();

    	$allsites = $user->websites()->with('theme')->get();
    	$activeWebsites = $user->websites()->where('active', 1)->get();
    	$notactiveWebsites = $user->websites()->where('active', 0)->get();
    	$totalSum = $this->totalCount($notactiveWebsites);

    	return view('billing')->with('websites', $allsites)->with('totalSum', sprintf("%.2f", $totalSum))->with('activeWebsites', $activeWebsites)->with('nonactivesites', $notactiveWebsites);
    }

    /**
     * Couts total sum of not payed websites
     *
     * @return Double
     */
    private function totalCount($nonactivesites){
    	$totalSum = 0;
    	foreach ($nonactivesites as $key => $website) {
    		$totalSum += $website->theme->price;
    	}
    	return $totalSum;
    }

    /**
     * Show page for selecting token type.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTokenPage(){
        return view('token');
    }

     /**
     * Show page for creating content update token.
     *
     * @return \Illuminate\Http\Response
     */
    public function showElementsPage(){
    	return view('contentElements');
    }
}
