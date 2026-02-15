<?php

namespace App\Searches;

use App\Models\Users\User;
use App\Searches\BaseSearchResult;

class SelectIds extends BaseSearchResult implements DisplayUsers
{
    // 改修課題：選択科目の検索機能
    public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
    {
        if (is_null($gender)) {
            $gender = ['1', '2', '3'];
        } else {
            $gender = [$gender];
        }
        if (is_null($role)) {
            $role = ['1', '2', '3', '4'];
        } else {
            $role = [$role];
        }

        if (is_null($keyword)) {
            $users = User::with('subjects')->whereIn('sex', $gender)->whereIn('role', $role)->orderBy('id', $updown)->get();
        } else {
            $users = User::with('subjects')->where('id', $keyword)->whereIn('sex', $gender)->whereIn('role', $role)->orderBy('id', $updown)->get();
        }
        return $users;
    }
}
