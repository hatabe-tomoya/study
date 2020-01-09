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
                    <form method="post" action="{{ route('changepassword') }}"  enctype="multipart/form-data">
                        @csrf
                    
                        <div class="form-group row">
                            <label for="current" class="col-md-4 col-form-label text-md-right">{{ __('messages.Current Password') }}</label>
                            <div class="col-md-6">
                                <input id="current" type="password" class="form-control @error('password') is-invalid @enderror" name="current-password" required>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.New Password') }}</label>
                            
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="new-password" required>
                                @if ($errors->has('new-password'))
                                      <span class="text-danger">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                      </span>
                                    @endif
                                <h6>※８文字以上</h6>
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