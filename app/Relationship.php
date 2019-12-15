<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $table = 'relationship';
    
    protected $fillable = [
        'following_id', 'followed_id',
    ];
    
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];
    
    public $incrementing = false;
    
    
    public function getFollowCount($user_id) {
        return $this->where('following_id', $user_id)->count();
    }

    public function getFollowerCount($user_id) {
        return $this->where('followed_id', $user_id)->count();
    }
}
