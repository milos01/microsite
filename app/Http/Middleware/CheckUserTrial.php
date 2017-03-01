<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

class CheckUserTrial
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if($user->trial_ends_at){
            $expireInDays = Carbon::now()->diffInDays($user->trial_ends_at);
            if($expireInDays == 0){
                return redirect('home')->with('trialExpiredText', 'You tral expired go to billing page');
            }else{
                return redirect('/home')->with('trialExpiredText', $expireInDays);
            }
        }

        return $next($request);
    }
}
