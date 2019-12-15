<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title','study_book','body','result','reference_image'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function like() {
        return $this->hasMany(Like::class);
    }
    
    public function comment() {
         return $this->hasMany(Comment::class);
    }
     
    public function getUserTimeLine(Int $user_id) {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }
    
    public function getPostCount(Int $user_id) {
        return $this->where('user_id', $user_id)->count();
    }
    
    
    
}
