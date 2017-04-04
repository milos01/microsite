<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Events\DeactivateWebsites;

class UserTrialComposer
{
    public $user;

    /**
     * Create a new profile composer.
     *
     */
    public function __construct(){
        $this->user = Auth::user();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $userWebsites = $this->user->websites()->with('theme')->where('active', 1)->get();
      
        if($this->user->trial_ends_at){
            $expireInDays = Carbon::now()->diffInDays($this->user->trial_ends_at, false);
            if($expireInDays <= 0){
                $this->user->trial_ends_at = null;
                $this->user->save();
                event(new DeactivateWebsites($userWebsites));
                $view->with('userTrialExpired', 'Expired, go to billing page');
            }else if($expireInDays > 0){
                $view->with('userTrial', $expireInDays);
            }
        }else{
            $view->with('userTrialExpired', 'Expired, go to billing page');
        }
    }
}