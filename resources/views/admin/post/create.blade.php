@extends('layouts.admin')

@section('title', '勉強法作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>勉強法作成</h2>
                <form action = "{{ action('Admin\PostController@create') }}" method ="post" enctype ="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors -> all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class ="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class ="col-md-10">
                            <input type ="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class ="form-group row">
                        <label class="col-md-2">参考書・教材</label>
                        <div class ="col-md-10">
                            <input type ="text" class="form-control" name="study_book" value="{{ old('study_book') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">勉強法</label>
                        <div class ="col-md-10">
                            <textarea class ="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">成果</label>
                        <div class ="col-md-10">
                            <textarea class ="form-control" name="result" rows="5">{{ old('result') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="投稿">
                </form>
            </div>
        </div>
    </div>
@endsection