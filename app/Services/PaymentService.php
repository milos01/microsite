<?php

namespace App\Services;

use App\User;
use App\Http\Controllers\Helpers\UserHelper as Usr;
use App\Http\Controllers\Helpers\BraintreeHelper as Brain3;
use Carbon\Carbon;


class PaymentService
{
    use Usr;
    use Brain3;

    public function __construct()
    {
  
    }

    public function automatedPaymentExpired($userInfo){
        $now = Carbon::now();
        $nextMonthAhead = $now->addMonth();
        foreach ($userInfo as $key => $info) {
            $user = $this->findUserById($info['id']);
            $result = $this->b3Sale($user, $info['totalPrice'], false, false);
            if ($result->success) {
                foreach ($user->websites as $key => $website) {
                    if($website->expire_at && $now->diffInDays($website->expire_at, false) <= 0){
                        $website->expire_at = $nextMonthAhead;
                        $website->save();
                    }
                }
            }
        }
        echo "Monthly subscription payment executed \n";
    }

}