<?php
namespace App\Http\Controllers\Helpers;
use App\User;
use Auth;

trait UserHelper {

     /**
     * Find user by id.
     *
     * @return User
     */
    public function findUserById($id) {
        $user = User::findorFail($id);
        return $user;
    }

     /**
     * Find both acticve and inactive users by id.
     *
     * @return User
     */
    public function findUserWithTrashed($id) {
        $user = Auth::withTrashed()->findorFail($id);
        return $user;
    }

     /**
     * Get logged user.
     *
     * @return User
     */
    public function loggedUser() {
        $user = Auth::user();
        return $user;
    }

    /**
     * Get logged user id.
     *
     * @return Integer
     */
    public function loggedUserId() {
        $id = Auth::id();
        return $id;
    }
}