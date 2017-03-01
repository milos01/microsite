<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\User;
use Auth;
use Carbon\Carbon;

class UserTrialComposer
{
    /**
     * Create a new profile composer.
     *
     */
    public function __construct(){}

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $user = Auth::user();
        if($user->trial_ends_at){
            $expireInDays = Carbon::now()->diffInDays($user->trial_ends_at, false);
            if($expireInDays <= 0){
                $view->with('userTrialExpired', 'Expired, go to billing page');
            }else if($expireInDays > 0){
                $view->with('userTrial', $expireInDays);
            }
        }


        
    }
}