<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    public $timestamps = false;
    
    //いいねカウント
    public function getLikeCount($post_id)
    {
        return $this->where('user_id', $post_id)->count();
    }

   
    public function isLike(Int $user_id, Int $post_id) 
    {
        return (boolean) $this->where('user_id', $user_id)->where('post_id', $post_id)->first();
    }

    public function storeLike(Int $user_id, Int $post_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->save();

        return;
    }

    public function destroyLike(Int $like_id)
    {
        return $this->where('id', $like_id)->delete();
    }
    
     //いいねユーザー取得
   public function getLikeTimeLines(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }

}
