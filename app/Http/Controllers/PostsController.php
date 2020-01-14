<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Comment;
use App\Relationship;
use App\User;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request, Post $post, Relationship $relationship)
   {
       $posts = Post::latest()->paginate(6);
       $user = auth()->user();
       
       //テスト
       if($request->has('keyword')) {
            $posts = Post::where('title', 'like', '%'.$request->get('keyword').'%')
                       ->orWhere('body', 'like', '%'.$request->get('keyword').'%')->paginate(6);
        }else{
            $posts = Post::latest()->paginate(6);
        }
        
       
       return view('posts.index', ['posts' => $posts, 'user' => $user]);
          
    }
    /*テスト検索用
    public function searchIndex(Request $request)
    {
        $posts = Post::where('title', $request->title)-> get();
        return view('posts.index', ['posts' => $posts]) ;
    
    }*/


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        
        return view('posts.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'title'      => ['required', 'string','max:90'],
            'study_book' => ['required', 'string','max:90'],
            'body'       => ['required', 'string','max:2000'],
            'result'     => ['required', 'string','max:180']
        ]);
        $validator->validate();
        $post->postStore($user->id, $data);
        
        return redirect('posts');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Comment $comment)
    {
        $user = auth()->user();
        $post = $post->getPost($post->id);
        $comments = $comment->getComments($post->id);

        return view('posts.show', [
            'user'     => $user,
            'post' => $post,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
         $user = auth()->user();
         $posts = $post->getEditPost($user->id, $post->id);
         
         if (!isset($posts)) {
            return redirect('posts');
        }
        
        return view('posts.edit', [
            'user'   => $user,
            'posts' => $posts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
         $data = $request->all();
         $validator = Validator::make($data, [
            'title'      => ['required', 'string','max:90'],
            'study_book' => ['required', 'string','max:90'],
            'body'       => ['required', 'string','max:2000'],
            'result'     => ['required', 'string','max:180']
        ]);
        
        $validator->validate();
        $post->postUpdate($post->id, $data);
        
        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user = auth()->user();
        $post->postDestroy($user->id, $post->id);
        
        return back();
    }
    
   
}
