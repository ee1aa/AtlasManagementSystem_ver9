<?php

namespace App\Searches;

use App\Models\Users\User;

class SearchResultFactories
{
    // 改修課題：選択科目の検索機能
    public function initializeUsers($keyword, $category, $updown, $gender, $role, $selectedSubjectIds)
    {
        $hasSubjects = !empty($selectedSubjectIds);

        if ($category === 'name') {
            $searchResults = $hasSubjects ? new SelectNameDetails() : new SelectNames();
            return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $selectedSubjectIds);
        }

        if ($category === 'id') {
            $searchResults = $hasSubjects ? new SelectIdDetails() : new SelectIds();
            return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $selectedSubjectIds);
        }

        $allUsers = new AllUsers();
        return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $selectedSubjectIds);
    }
}
