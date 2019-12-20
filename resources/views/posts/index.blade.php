@extends('layouts.app')
@section('title', '勉強法一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>勉強法一覧</h2>
        </div>
        
        <div class="row">
            @foreach($posts as $post)
                <div class ="study-card p-0 col-lg-4 col-md-6 col-sm-12">
                    <div class ="card m-3">
                        <div class ="card-header">
                          <a href ="{{ url('posts/' .$post->id) }}" class="text-secondary">{{ $post->title }}</a>
                            <div class ="card-body">
                              <p>{!! nl2br(e($post->body)) !!}</p>
                            </div>
                            <div class ="card-footer">
                                <div class ="user">
                                    <p class ="float-left">
                                        <a href ="#">
                                            <img src ="#">
                                        </a>
                                        <div class="ml-2 d-flex flex-column">
                                           <a href ="{{ url('users/' .$post->user->id) }}" class="text-secondary">{{ $post->user->name }}</a>
                                        </div>
                                    </p>
                                </div>
                                <div class ="like">
                                    <div class="float-right">
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
        
        <div class="my-4 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection