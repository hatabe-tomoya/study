@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-sm-4 ">
            <div class="card">
                <div class="profile border-black">
                    <div class="p-3 d-flex justify-content-center">
                        @if($user->icon_image == null)
                            <img src="{{ '/assets/img/itWz22pzRoBOwTB2Hz1qYGuKvbfvRXaCB94gzuf7.jpeg' }}" class="rounded-circle" width="100" height="100">
                        @else
                            <img src="{{ $user->icon_image }}" class="rounded-circle" width="100" height="100">
                        @endif
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <h4 class="mb-0 font-weight-bold">{!! nl2br(e(str_limit($user->name, 20))) !!}</h4>
                    </div>
                    <div class="profile-edit pt-2">
                        @if ($user->id === Auth::user()->id)
                            <div class="acount-edit d-flex justify-content-center pt-2">
                                <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">アカウントを編集する</a>
                            </div>
                            <div class="password-edit d-flex justify-content-center mt-4">
                                <a href="{{ url('changepassword') }}" class="btn btn-secondary">パスワードを編集する</a>
                            </div>
                        @else
                            @if ($is_following)
                                <div class="follow-edit d-flex justify-content-center pt-2">
                                    <form action="{{ route('unfollow', ['id' => $user->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
    
                                        <button type="submit" class="btn btn-danger pt-2 mb-2">フォロー解除</button>
                                    </form>
                                </div>
                            @else
                                <div class="follow-edit d-flex justify-content-center pt-2">
                                    <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
                                        {{ csrf_field() }}
    
                                        <button type="submit" class="btn btn-primary pt-2 mb-2">フォローする</button>
                                    </form>
                                </div>
                            @endif
                            
                            @if ($is_followed)
                                <span class="d-flex justify-content-center mt-2 px-1 ">フォローされています</span>
                            @endif
                         @endif
                    </div>
                    <div class="profile-counts ">
                        <div class="follow-link mt-4">
                            <div class="users-follow-link d-flex justify-content-around">
                                 <div class="profile-follow-count ">
                                    
                                    <a href="{{ url('users/' .$user->id .'/follows_index') }}" class="font-weight-bold">フォロー</a>
                                    <p class ="follow-count d-flex justify-content-center">{{ $follow_count }}</p>
                                </div>
                                <div class="profile-follower-count ">
                                    <a href="#" class="font-weight-bold">フォロワー</a>
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
                                    <a href="{{ url('users/' .$user->id .'/likes_index') }}" class="font-weight-bold">いいね</a>
                                    <p class="like-count d-flex justify-content-center">{{ $like_count }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class ="users-study-stock p-0 col-sm-8">
            <div class ="title text-center p-3 "><h3>フォロワーユーザーの一覧</h3></div>
                <div class ="container">
                    <div class ="row">
                        @if (isset($timelines))
                            @foreach ($timelines as $timeline)
                                <div class="study-card p-0 col-lg-6 col-md-12">
                                    <div class ="card m-3">
                                        <div class ="card-header d-flex">
                                            @if($timeline->icon_image == null)
                                                <img src="{{ '/assets/img/itWz22pzRoBOwTB2Hz1qYGuKvbfvRXaCB94gzuf7.jpeg' }}" class="rounded-circle" width="30" height="30">
                                            @else
                                                <img src="{{ $timeline->icon_image }}" class="rounded-circle" width="30" height="30">
                                            @endif
                                            <a href ="{{ url('users/' .$timeline->id) }}" class="text-secondary">{!! nl2br(e(str_limit($timeline->name, 20))) !!}</a>
                                        </div>
                                        <div class="card-footer py-1 bg-white">
                                            <div class="float-right">
                                                <div class ="like">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-book"></i>
                                                            <div class="mb-0 text-secondary">{{ count($timeline->posts) }}</div>
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