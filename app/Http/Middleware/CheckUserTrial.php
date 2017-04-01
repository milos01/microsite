<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

class CheckUserTrial
{
    public $now;

    public function __construct()
    {
        $this->now = Carbon::now();
    }
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
        $userWebsites = $user->websites()->with('theme')->get();
        foreach ($userWebsites as $key => $site) {
            if ($site->expire_at && $site->active == 1) {
                if($this->now->diffInDays($site->expire_at, false) <= 0){
                    $site->expire_at = Carbon::parse($site->expire_at)->addMonth();
                    $site->save();
                }
                
                //event for billing
            }
        }
        

        return $next($request);
    }
}
