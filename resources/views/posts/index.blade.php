@extends('layouts.app')
@section('title', '勉強法一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>勉強法一覧</h2>
        </div>
        
        
        <div class="row">
            <div class ="study-card p-0 col-lg-4 col-md-6 col-sm-12">
                <div class ="card m-3">
                    <div class ="card-header">
                      <a href ="#"> {!! nl2br(e($post->title)) !!}</a>
                        <div class ="card-body">
                          <p>テスト１</p>
                        </div>
                        <div class ="card-footer">
                            <div class ="user">
                                <p class ="float-left">
                                    <a href ="#">
                                        <img src ="#">
                                    </a>
                                    <a href ="#">あーく</a>
                                </p>
                            </div>
                            <div class ="like">
                                <p class="float-right">
                                    <i class="fas fa-heart fa-fw text-danger">
                                
                                    </i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        
            <div class ="study-card p-0 col-lg-4 col-md-6 col-sm-12">
                <div class ="card m-3">
                    <div class ="card-header">
                      <a href ="#">あ</a>
                        <div class ="card-body">
                          <p>テスト１</p>
                        </div>
                        <div class ="card-footer">
                            <div class ="user">
                                <p class ="float-left">
                                    <a href ="#">
                                        <img src ="#">
                                    </a>
                                    <a href ="#">あーく</a>
                                </p>
                            </div>
                            <div class ="like">
                                <p class="float-right">
                                    <i class="fas fa-heart fa-fw text-danger">
                                
                                    </i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        
            <div class ="study-card p-0 col-lg-4 col-md-6 col-sm-12">
                <div class ="card m-3">
                    <div class ="card-header">
                      <a href ="#">あ</a>
                        <div class ="card-body">
                          <p>テスト１</p>
                        </div>
                        <div class ="card-footer">
                            <div class ="user">
                                <p class ="float-left">
                                    <a href ="#">
                                        <img src ="#">
                                    </a>
                                    <a href ="#">あーく</a>
                                </p>
                            </div>
                            <div class ="like">
                                <p class="float-right">
                                    <i class="fas fa-heart fa-fw text-danger">
                                
                                    </i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
            
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">タイトル</th>
                                <th width="50%">本文</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <th>{{ $post->id }}</th>
                                    <td>{{ \Str::limit($post->title, 100) }}</td>
                                    <td>{{ \Str::limit($post->body, 250) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection