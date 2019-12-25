<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Post;
use App\Relationship;
use App\Like;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user) 
    {
        $all_users = $user->getAllUsers(auth()->user()->id);
        
        return view('users.index', [
            'all_users' => $all_users]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Post $post, Relationship $relationship, Like $like)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $post->getUserTimeLine($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $relationship->getFollowCount($user->id);
        $follower_count = $relationship->getFollowerCount($user->id);
        //いいねカウント
        $like_count = $like->getLikeCount($user->id);
        
        return view('users.show', [
            'user' => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'post_count'    => $post_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
            //いいねカウント
            'like_count'     => $like_count
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {
         return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'icon_image'    => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
            ]);
            
        $validator->validate();
        $user->updateAccount($data);
        
        return redirect('users/'.$user->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
     
    public function follow(User $user)
    {
        $follower = auth()->user();
        
        $is_following = $follower->isFollowing($user->id);
        if(!$is_following) {
            $follower->follow($user->id);
            return back();
        }
    }

    
    public function unfollow(User $user)
    {
        $follower = auth()->user();
       
        $is_following = $follower->isFollowing($user->id);
        if($is_following) {
            $follower->unfollow($user->id);
            return back();
        }
    }
    
   //フォロー一覧を表示させるための処理
     public function followindex(User $user, Post $post, Relationship $relationship, Like $like)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        //$timelines = $post->getUserTimeLine($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $relationship->getFollowCount($user->id);
        $follower_count = $relationship->getFollowerCount($user->id);
        //いいねカウント
        $like_count = $like->getLikeCount($user->id);
        
        //フォローユーザー取得
        $user = auth()->user();
        $follow_ids = $relationship->followingIds($user->id);
        // followed_idだけ抜き出す
        $following_ids = $follow_ids->pluck('followed_id')->toArray();

        $timelines = $user->getFollowTimelines($user->id, $following_ids);

       
        
        return view('users.follows_index', [
            'user' => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'post_count'    => $post_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
            //いいねカウント
            'like_count'     => $like_count,
            ]);
    }
    
    //フォロワー一覧を表示させるための処理
     public function followerindex(User $user, Post $post, Relationship $relationship, Like $like)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        //$timelines = $post->getUserTimeLine($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $relationship->getFollowCount($user->id);
        $follower_count = $relationship->getFollowerCount($user->id);
        //いいねカウント
        $like_count = $like->getLikeCount($user->id);
        
        //フォローユーザー取得
        $user = auth()->user();
        $follower_ids = $relationship->followedIds($user->id);
        // followed_idだけ抜き出す
        $followed_ids = $follower_ids->pluck('following_id')->toArray();

        $timelines = $user->getFollowerTimelines($user->id, $followed_ids);

       
        
        return view('users.followers_index', [
            'user' => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'post_count'    => $post_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
            //いいねカウント
            'like_count'     => $like_count,
            
           
            ]);
            
       
        
    }
  
  
    
}
