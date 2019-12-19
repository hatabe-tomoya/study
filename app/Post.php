<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title','study_book','body','result','reference_image'
    ];
    
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    
    public function like() 
    {
        return $this->hasMany(Like::class);
    }
    
    public function comment() 
    {
         return $this->hasMany(Comment::class);
    }
     
    public function getUserTimeLine(Int $user_id) 
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }
    
    public function getPostCount(Int $user_id) 
    {
        return $this->where('user_id', $user_id)->count();
    }
    
    public function getPost(Int $post_id)
    {
        return $this->with('user')->where('id', $post_id)->first();
    }
    
    public function postStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->title = $data['title'];
        $this->save();

        return;
    }
    
    public function getEditPost(Int $user_id, Int $post_id)
    {
        return $this->where('user_id', $user_id)->where('id', $post_id)->first();
    }
    
    public function postUpdate(Int $post_id, Array $data)
    {
        $this->id = $post_id;
        $this->title = $data['title'];
        $this->update();

        return;
    }
    
    public function postDestroy(Int $user_id, Int $post_id)
    {
        return $this->where('user_id', $user_id)->where('id', $post_id)->delete();
    }
    
}
