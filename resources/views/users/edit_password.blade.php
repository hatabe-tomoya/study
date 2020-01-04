@extends('layouts.app')



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワード編集</div>
                
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
                    <form method="POST"action="{{ url('users/' .$user->id) }}"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        
                        

                        
                        
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
                        
                         <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="new-password" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="confirm" class="col-md-4 col-form-label text-md-right">{{ __('messages.Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="confirm" type="password" class="form-control" name="new-password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="更新" class="btn btn-primary btn-sm" >
                            </div>
                        </div>
                    </form>
                        
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection