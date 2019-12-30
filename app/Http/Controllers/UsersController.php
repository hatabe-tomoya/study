<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Post;
use App\Relationship;
use App\Like;
use Auth;
use Hash;


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
        $this->validate($request, User::$rules);
        $user = User::find($request->id);
        $user_form = $request->all();
        
        if (isset($user_form['icon_image'])) {
        $path = $request->file('icon_image')->store('public/icon_image');
        $user->icon_image = basename($path);
        unset($news_form['icon_image']);
      } elseif (isset($request->remove)) {
        $user->icon_image = null;
        unset($user_form['remove']);
      }
      unset($user_form['_token']);
      
        //$user->updateAccount($data);
        
          
        
        //現在のパスワードが正しいかを調べる
         if(!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }
        //現在のパスワードと新しいパスワードが違っているかを調べる
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }
         //パスワードを変更
        $user = auth()->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->fill($user_form)->save();


        return redirect('users/'.$user->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();
        $user->delete();
        
        return redirect('/');
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
        
        //フォロワーーユーザー取得
        $user = auth()->user();
        $follower_ids = $relationship->followedIds($user->id);
       
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
    
    //いいね一覧を表示
     public function likeindex(User $user, Post $post, Relationship $relationship, Like $like)
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
        
       
        

        $timelines = $like->getLikeTimeLines($user->id, $id);

       
        
        return view('users.likes_index', [
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
