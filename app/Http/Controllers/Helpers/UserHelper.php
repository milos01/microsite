<?php
namespace App\Http\Controllers\Helpers;
use App\User;
use Auth;

trait UserHelper {
    public static function findUserById($id) {
        $user = User::findorFail($id);
        return $user;
    }

    public static function findUserWithTrashed($id) {
        $user = Auth::withTrashed()->findorFail($id);
        return $user;
    }

    public function loggedUser() {
        $user = Auth::user();
        return $user;
    }

    public static function loggedUserId() {
        $id = Auth::id();
        return $id;
    }
}