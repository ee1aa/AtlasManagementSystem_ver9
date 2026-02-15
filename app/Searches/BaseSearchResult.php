<?php

namespace App\Searches;

use App\Models\Users\User;

abstract class BaseSearchResult
{
    protected function baseQuery()
    {
        return User::query()->with('subjects');
    }
}
