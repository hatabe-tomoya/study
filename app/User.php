<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','icon_image',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function posts() 
    {
        return $this->hasMany(Post::class);
    }
    
    
    protected $guarded = array('id');

    
    public static $rules = array(
        'name' => 'required|string|max:255',
        'icon_image'       => 'file|image|mimes:jpeg,png,jpg|max:2048',
        'email'            => 'required|string|email|max:255',
        'current-password' => 'required',
        
    );
    
    public static $passwordchangerules = array(
        'current-password' => 'required',
        'new-password'     => 'required|string|min:8|confirmed'
        );
    
    
   public function followers() {
        return $this->belongsToMany(self::class, 'relationship', 'followed_id', 'following_id');
    }

    public function follows() {
        return $this->belongsToMany(self::class, 'relationship', 'following_id', 'followed_id');
    }
   
   public function getAllUsers(Int $user_id) {
       return $this->Where('id','<>', 'user_id' )->paginate(5);
   }
   
    public function follow(Int $user_id) {
        return $this->follows()->attach($user_id);
    }

    public function unfollow(Int $user_id) {
        return $this->follows()->detach($user_id);
    }

    public function isFollowing(Int $user_id) {
        return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }

    public function isFollowed(Int $user_id) {
        return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }
    
    
   //フォローユーザー取得
   public function getFollowTimeLines(Int $user_id, Array $following_ids)
    {
        return $this->whereIn('id', $following_ids)->orderBy('created_at', 'DESC')->paginate(50);
    }
    
    //フォロワーユーザー取得
   public function getFollowerTimeLines(Int $user_id, Array $follower_ids)
    {
        return $this->whereIn('id', $follower_ids)->orderBy('created_at', 'DESC')->paginate(50);
    }
    
   
   
}