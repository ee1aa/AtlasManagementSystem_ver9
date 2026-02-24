<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'subject'
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,          // 相手モデル
            'subject_users',      // 中間テーブル名
            'subject_id',          // 中間テーブル側の subject の外部キー
            'user_id'            // 中間テーブル側の user の外部キー
        )->withTimestamps(); // リレーションの定義
    }
}
