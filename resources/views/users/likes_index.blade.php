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
                    
                        <div class="profile-edit d-flex justify-content-center">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">アカウントを編集する</a>
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
                                        <span class="mt-2 px-1 bg-secondary text-light">フォローされています</span>
                                    @endif
                                 @endif
                            </div>
                        </div>
                        <div class="profile-counts ">
                            <div class="follow-link mt-4">
                                <div class="users-follow-link d-flex justify-content-around">
                                     <div class="profile-follow-count ">
                                        
                                        <a href="{{ url('users/' .$user->id .'/follows_index') }}" class="font-weight-bold">フォロー</a>
                                        <p class ="follow-count d-flex justify-content-center">{{ $follow_count }}</p>
                                    </div>
                                    <div class="profile-follower-count ">
                                        <a href="{{ url('users/' .$user->id .'/followers_index') }}" class="font-weight-bold">フォロワー</a>
                                        <p class="follower-count d-flex justify-content-center">{{ $follower_count }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="study-like-link">
                                <div class="users-study-like-link d-flex justify-content-around">
                                    <div class="profile-study-count mr-2">
                                        
                                        <a href="{{ url('users/' .$user->id ) }}" class="font-weight-bold">作成済勉強法</a>
                                        <p class="study-count d-flex justify-content-center">{{ $post_count }}</p>
                                    </div>
                                    <div class="profile-like-count pr-3">
                                        <a href="#" class="font-weight-bold">いいね</a>
                                        <p class="like-count d-flex justify-content-center">{{ $like_count }}</p>
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div>
                    
                </div>
            </div>
        </div>
        
        
        <div class ="users-study-stock p-0  col-sm-8">
            <div class ="title text-center p-3 "><h3>いいね</h3></div>
                <div class ="container">
                    <div class ="row">
                        @if (isset($timelines))
                            @foreach ($timelines as $timeline)
                                <div class="study-card p-0 col-lg-6 col-md-12">
                                    <div class ="card m-3">
                                            <div class ="card-header">
                                                <a href ="{{ url('posts/' .$timeline->post->id) }}" class="text-secondary">{{ $timeline->post->title }}</a>
                                                <div class="ml-2 d-flex flex-column flex-grow-1">
                                                </div>
                                            </div>
                                        
                                        <div class="card-body">
                                            {!! nl2br(e(str_limit($timeline->post->body, 50))) !!}
                                        </div>
                                        <div class="card-footer py-1  bg-white">
                                            <div class ="user">
                                                    <p class ="float-left mb-1">
                                                        <a href ="#">
                                                            <img src ="#">
                                                        </a>
                                                        {{--リンク先設定完了--}}
                                                        <a href ="{{ url('users/' .$timeline->post->id) }}" class="text-secondary">{{ $timeline->post->user->name }}</a>
                                                    </p>
                                                </div>
                                                <div class="float-right">
                                                    <div class ="like">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-heart fa-fw text-danger"></i>
                                                                <div class="mb-0 text-secondary">{{ count($timeline->like) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="d-flex align-items-center">
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