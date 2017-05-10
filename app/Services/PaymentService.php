<?php

namespace App\Services;

use App\User;
use App\Http\Controllers\Helpers\UserHelper as Usr;
use App\Http\Controllers\Helpers\BraintreeHelper as Brain3;


class PaymentService
{
    use Usr;
    use Brain3;

    public function __construct()
    {
  
    }

    public function automatedPaymentExpired($userInfo){

        foreach ($userInfo as $key => $info) {
            $user = $this->findUserById($info['id']);
            $result = $this->b3Sale($user, $info['totalPrice'], false, false);
        }
        echo "Monthly subscription payment executed \n";
    }

}