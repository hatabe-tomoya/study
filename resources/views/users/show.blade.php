@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="d-inline-flex">
                    <div class="p-3 d-flex flex-column">
                        <img src="{{ asset('storage/icon_image/' .$user->icon_image) }}" class="rounded-circle" width="100" height="100">
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>
                            <span class="text-secondary">{{ $user->screen_name }}</span>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">プロフィールを編集する</a>
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
                        <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">作成済勉強法</p>
                                <span>{{ $post_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロー</p>
                                <span>{{ $follow_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロワー</p>
                                <span>{{ $follower_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">いいね</p>
                                <span>{{ $like_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($timelines))
            @foreach ($timelines as $timeline)
                <div class ="study-card p-0 col-lg-4 col-md-6 col-sm-12">
                    <div class ="card m-3">
                        <div class ="card-header">
                            <a href ="{{ url('posts/' .$timeline->id) }}" class="text-secondary">{{ $timeline->title }}</a>
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                
                                
                            </div>
                            
                        </div>
                        <div class="card-body">
                            {{ $timeline->body }}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            <div class ="user">
                                    <p class ="float-left">
                                        <a href ="#">
                                            <img src ="#">
                                        </a>
                                        <a href ="{{ url('users/' .$timeline->user->id) }}" class="text-secondary">{{ $timeline->user->name }}</a>
                                    </p>
                                </div>
                                <div class ="like">
                                    <div class="float-right">
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
    <div class="my-4 d-flex justify-content-center">
        {{ $timelines->links() }}
    </div>
</div>
@endsection