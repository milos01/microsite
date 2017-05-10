<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Website;
use Carbon\Carbon;
use Log;
use App\Services\PaymentService as PService;

class CheckExpireDate extends Command
{
    public $pService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'microsite:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for webistes expite date in database. If date has expirted sets website to inactive.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PService $pservice)
    {
        parent::__construct();
        $this->pService = $pservice;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $userTotal = 0;
        $uId = -1;
        $indexList = [];
        $userInfo = [];

        $now = Carbon::now();
        $websites = Website::with('theme')->get();
        foreach ($websites as $key => $website) {
            if($website->grace_period && $website->active == 1 && $now->diffInDays($website->grace_period, false) <= 0){
                $website->active = 0;
                
                $website->save();
            }else if($website->expire_at && $website->active == 1 && $now->diffInDays($website->expire_at, false) <= 0){
                if($uId == -1){
                    $uId = $website->user->id;
                    array_push($indexList, $uId);
                    $userTotal = $this->groupUserInfo($websites, $uId, $userTotal, $now);
                    $userInfoItem = [
                        'id' => $uId,
                        'totalPrice' => $userTotal
                    ];
                    array_push($userInfo, $userInfoItem);
                    $userTotal = 0;
                }else{
                    $uId = $website->user->id;
                    if(!in_array($uId, $indexList)){
                        $uId = $website->user->id;
                        
                        array_push($indexList, $uId);
                        $userTotal = $this->groupUserInfo($websites, $uId, $userTotal, $now);
                        $userInfoItem = [
                            'id' => $uId,
                            'totalPrice' => $userTotal
                        ];
                        array_push($userInfo, $userInfoItem);
                        $userTotal = 0;
                    }
                }
            }
        }
        $this->pService->automatedPaymentExpired($userInfo);
        $indexList = [];
    }

    private function groupUserInfo($websites, $uid, $userTotal, $now){
        foreach ($websites as $key => $webSite) {
            if($webSite->expire_at && $webSite->active == 1 && $now->diffInDays($webSite->expire_at, false) <= 0){
                if($webSite->user->id == $uid){
                    $userTotal += $webSite->theme->price;
                }
            }
        }
        return $userTotal;
    }
}
