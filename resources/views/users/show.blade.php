@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-sm-4 ">
            <div class="card">
                <div class="profile border-black">
                    <div class="p-3 d-flex flex-column ">
                        <img src="{{ asset('storage/icon_image/' .$user->icon_image) }}" class="rounded-circle" width="100" height="100">
                        <div class="mt-3 d-flex justify-content-center">
                            <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>
                            <span class="text-secondary">{{ $user->screen_name }}</span>
                        </div>
                    </div>
                    
                        <div class="profile-edit">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <div class="acount-edit d-flex justify-content-center">
                                        <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">アカウントを編集する</a>
                                    </div>
                                    <div class="password-edit d-flex justify-content-center mt-4">
                                        <a href="{{ url('changepassword') }}" class="btn btn-secondary">パスワードを編集する</a>
                                    </div>
                                @else
                                
                                 
                                
                                    @if ($is_following)
                                        <form action="{{ route('unfollow', ['id' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            
                                            <button type="submit" class="btn btn-danger">フォロー解除</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-primary">フォローする</button>
                                        </form>
                                    @endif

                                    @if ($is_followed)
                                        <div class="mt-2 px-1 bg-info text-light">フォローされています</div>
                                    @endif
                                 @endif
                            </div>
                        </div>
                        <div class="profile-counts ">
                            <div class="follow-link mt-4">
                                <div class="users-follow-link d-flex justify-content-around">
                                     <div class="profile-follow-count ">
                                        {{--フォローへのリンク--}}
                                        <a href="{{ url('users/' .$user->id .'/follows_index') }}" class="font-weight-bold">フォロー</a>
                                        <p class ="follow-count d-flex justify-content-center">{{ $follow_count }}</p>
                                    </div>
                                    <div class="profile-follower-count ">
                                        {{--フォロワーへのリンク--}}
                                        <a href="{{ url('users/' .$user->id .'/followers_index') }}" class="font-weight-bold">フォロワー</a>
                                        <p class="follower-count d-flex justify-content-center">{{ $follower_count }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="study-like-link">
                                <div class="users-study-like-link d-flex justify-content-around">
                                    <div class="profile-study-count mr-2">
                                        
                                        <a href="#" class="font-weight-bold">作成済勉強法</a>
                                        <p class="study-count d-flex justify-content-center">{{ $post_count }}</p>
                                    </div>
                                    <div class="profile-like-count pr-3">
                                        <a href="{{ url('users/' .$user->id .'/likes_index') }}" class="font-weight-bold">いいね</a>
                                        <p class="like-count d-flex justify-content-center">{{ $like_count }}</p>
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div>
                    
                </div>
            </div>
        </div>
        
        
        <div class ="users-study-stock p-0  col-sm-8">
            <div class ="title text-center p-3 "><h3>作成済勉強法</h3></div>
                <div class ="container">
                    <div class ="row">
                        @if (isset($timelines))
                            @foreach ($timelines as $timeline)
                                <div class="study-card p-0 col-lg-6 col-md-12">
                                    <div class ="card m-3">
                                        <div class ="card-header">
                                            <a href ="{{ url('posts/' .$timeline->id) }}" class="text-secondary">{{ $timeline->title }}</a>
                                        </div>
                                        <div class="card-body">
                                            {!! nl2br(e(str_limit($timeline->body, 35))) !!}
                                        </div>
                                        <div class="card-footer py-1  bg-white">
                                            <div class ="user">
                                                <p class ="float-left mb-1">
                                                    <a href ="#">
                                                        <img src ="#">
                                                    </a>
                                                    
                                                     <a href ="{{ url('users/' .$timeline->user->id) }}" class="text-secondary">{{ $timeline->user->name }}</a>
                                                    
                                                </p>
                                            </div>
                                            <div class="float-right ">
                                                <div class ="like">
                                                    <div class="d-flex flex-row-reverse">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-heart fa-fw text-danger"></i>
                                                                <div class="mb-0 text-secondary">{{ count($timeline->like) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
        　　</div>
    　　</div>
        <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
        </div>
　　</div>
</div>
@endsection
                                        