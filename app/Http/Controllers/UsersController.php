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
    public function index() 
    {
       //
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
        $like_count = $like->getLikeCount($user->id);
        
        return view('users.show', [
            'user' => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'post_count'    => $post_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
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
         $user = auth()->user();
         
         return view('users.edit', ['user' => $user,]);
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
        $user_form = $request->all();
        
        if (isset($user_form['icon_image'])) {
        $path = $request->file('icon_image')->store('public/icon_image');
        $user->icon_image = basename($path);
        unset($user_form['icon_image']);
      } elseif (isset($request->remove)) {
        $user->icon_image = null;
        unset($user_form['remove']);
      }
        unset($user_form['_token']);
        
         if(!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }
        
        $user->fill($user_form)->save();
        return redirect('users/'.$user->id)->with('update_account_success', 'アカウントを編集しました。');

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
    
   
     public function followindex(User $user, Post $post, Relationship $relationship, Like $like)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $relationship->getFollowCount($user->id);
        $follower_count = $relationship->getFollowerCount($user->id);
        $like_count = $like->getLikeCount($user->id);
        
        $follow_ids = $relationship->followingIds($user->id);
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
            'like_count'     => $like_count,
            ]);
    }
    
    
     public function followerindex(User $user, Post $post, Relationship $relationship, Like $like)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $relationship->getFollowCount($user->id);
        $follower_count = $relationship->getFollowerCount($user->id);
        $like_count = $like->getLikeCount($user->id);
        
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
            'like_count'     => $like_count,
            ]);
    }
    
    
     public function likeindex(User $user, Post $post, Relationship $relationship, Like $like)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $post_count = $post->getPostCount($user->id);
        $follow_count = $relationship->getFollowCount($user->id);
        $follower_count = $relationship->getFollowerCount($user->id);
        $like_count = $like->getLikeCount($user->id);

        $timelines = $like->getLikeTimeLines($user->id, $id);
        
        return view('users.likes_index', [
            'user' => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'post_count'    => $post_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count,
            'like_count'     => $like_count,
            ]);
    }
    
    
    public function showPasswordForm(User $user)
    {
        return view('users.edit_password',['user_id'=>Auth::id()]);
    }
    
    public function changePassword(Request $request)
    {
        $this->validate($request, User::$passwordchangerules);
        $user = Auth::user();
        $user_form = $request->all();
        unset($user_form['_token']);
        
         if(!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }
        
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードは現在のパスワードとは別のパスワードで入力してください。');
        }
         
        $user = auth()->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->fill($user_form)->save();
        return redirect('users/'.$user->id)->with('change_password_success', 'パスワードを変更しました。');
    }
    
}
