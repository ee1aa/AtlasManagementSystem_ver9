<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\SubCategory;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories()
    {
        // リレーションの定義
        return $this->belongsTo(SubCategory::class);
    }

    // コメント数
    public function commentCounts($post_id)
    {
        return PostComment::where('post_id', $post_id)->count();
    }

    //いいね
    public function likes()
    {
        return $this->hasMany(Like::class, 'like_post_id');
    }
}
