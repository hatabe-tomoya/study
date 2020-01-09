@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勉強法作成</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf

                        <div class="form-group row mb-0">
                            <div class="col-md-12 p-3 w-100 d-flex">
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0">タイトル</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control @error('title') is-invalid @enderror" name="title" required autocomplete="title" rows="2">{{ old('title') }}</textarea>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12 p-3 w-100 d-flex">
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0">参考書・教材</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control @error('study_book') is-invalid @enderror" name="study_book" required autocomplete="study_book" rows="2">{{ old('study_book') }}</textarea>
                                @error('study_book')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12 p-3 w-100 d-flex">
                                
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0">勉強法</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control @error('body') is-invalid @enderror" name="body" required autocomplete="body" rows="20">{{ old('body') }}</textarea>

                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12 p-3 w-100 d-flex">
                                
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0">成果</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control @error('result') is-invalid @enderror" name="result" requied autocomplete="result" rows="4">{{ old('title') }}</textarea>

                                @error('result')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                       
                        
                        <div class="form-group row mt-4">
                            <div class="col-md-12 text-center">
                                
                                <button type="submit" class="btn btn-primary">
                                    投稿
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection