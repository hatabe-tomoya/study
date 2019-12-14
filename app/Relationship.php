<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $table = 'relationship';
    
    protected $fillable = [
        'following_id', 'followed_id',
    ];

}
