<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;

class UserPolice
{
    public function canAccess(User $user) {
        return $user->is_admin;
    }
}
