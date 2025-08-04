<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Policies;

use App\Models\User;

class UserPolicy {
    /**
     * Create a new policy instance.
     **/
    public function __construct() {
        //
    }

    public function isAuth(User $user): bool {
        return $user->id > 0;
    }

    public function isSuperAdmin(User $user): bool {
        return $user->roles === 1;
    }

    public function isAdmin(User $user): bool {
        return $user->roles > 1;
    }
}
