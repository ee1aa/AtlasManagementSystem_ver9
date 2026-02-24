<?php

namespace App\Searches;

use App\Models\Users\User;

abstract class BaseSearchResult
{
    protected function baseQuery(array $subjects = [])
    {
        return User::query()->with('subjects');

        // 科目が選択されているときだけ絞り込み（OR）
        if (!empty($subjects)) {
            $query->whereHas('subjects', function ($q) use ($subjects) {
                $q->whereIn('subjects.id', $subjects);
            });
        }

        return $query;
    }
}
