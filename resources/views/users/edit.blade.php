@extends('layouts.app')



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">アカウント編集</div>
                
                {{--エラーメッセージ用 --}}
                        @if (session('change_password_error'))
                  <div class="container mt-2">
                    <div class="alert alert-danger">
                      {{session('change_password_error')}}
                    </div>
                  </div>
                @endif
        
                @if (session('change_password_success'))
                  <div class="container mt-2">
                    <div class="alert alert-success">
                      {{session('change_password_success')}}
                    </div>
                  </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ url('users/' .$user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row align-items-center">
                            <label for="icon_image" class="col-md-4 col-form-label text-md-right">{{ __('messages.Icon Image') }}</label>

                            <div class="col-md-6 d-flex align-items-center">
                                <img src="{{ asset('storage/icon_image/' .$user->icon_image) }}" class="mr-2 rounded-circle" width="30" height="30" alt="icon_image">
                                <input type="file" name="icon_image" class="@error('icon_image') is-invalid @enderror" autocomplete="icon_image">

                                @error('icon_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
                        </div>
                        
                        

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('messages.Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('messages.E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="current" class="col-md-4 col-form-label text-md-right">{{ __('messages.Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="current" type="password" class="form-control @error('password') is-invalid @enderror" name="current-password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="更新" class="btn btn-primary btn-sm" >
                            </div>
                        </div>
                    </form>
                        <div class="center-block">
                            <form method="POST" action="{{ url('users/' .$user->id) }}" class="mb-0">
                                @csrf
                                @method('DELETE')
                                
                                <div class="col-md-6 offset-md-4">
                                    <h4>アカウント削除</h4>
                                    <input type="submit" value="削除" class="btn btn-danger btn-sm" onclick='return confirm("本当に削除しますか？");'>
                               </div>
                            </form>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection