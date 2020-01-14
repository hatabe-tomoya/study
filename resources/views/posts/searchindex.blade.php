@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2>勉強法一覧</h2>
            <div class="col-md-4">
                <form class="form-inline" >
                    <div class="form-group" action="route('posts/')" method="GET">
                        <input type="text" name="keyword" value="{{$keyword}}" class="form-control" placeholder="キーワード検索">
                        <input type="submit" value="検索" class="btn btn-info ml-1">
                    </div>
                </form>
            </div>
        </div>
        
        @if(count($posts) > 0)
            <div class="row">
                @foreach($posts as $post)
                    <div class ="study-card p-0 col-lg-4 col-md-6 col-sm-12">
                        <div class ="card m-3">
                            <div class ="card-header">
                              <a href ="{{ url('posts/' .$post->id) }}" class="text-secondary">{!! nl2br(e(str_limit($post->title, 40))) !!}</a>
                            </div>
                            <div class ="card-body">
                              {!! nl2br(e(str_limit($post->body, 40))) !!}
                            </div>
                            <div class="card-footer py-1 bg-white">
                                <div class ="user">
                                    <p class ="float-left mb-1">
                                        @if($post->user->icon_image == null)
                                            <img src="{{ asset('storage/icon_image/itWz22pzRoBOwTB2Hz1qYGuKvbfvRXaCB94gzuf7.jpeg') }}" class="rounded-circle" width="15" height="15">
                                        @else
                                            <img src="{{ asset('storage/icon_image/' .$post->user->icon_image) }}" class="rounded-circle" width="15" height="15">
                                        @endif
                                        <a href ="{{ url('users/' .$post->user->id) }}" class="text-secondary">{{ $post->user->name }}</a>
                                    </p>
                                </div>
                                <div class="float-right">
                                    <div class ="like">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-heart fa-fw text-danger"></i>
                                                    <div class="mb-0 text-secondary">{{ count($post->like) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                @endforeach
            </div>
        @endif
        <div class="my-4 d-flex justify-content-center">
            {{ $posts->appends(['keyword' => Request::get('keyword')])->links() }}
        </div>
    </div>
@endsection