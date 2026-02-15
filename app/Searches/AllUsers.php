<?php

namespace App\Searches;

use App\Models\Users\User;
use App\Searches\BaseSearchResult;

class AllUsers extends BaseSearchResult implements DisplayUsers
{
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        $users = User::all();
        return $users;
    }
}
