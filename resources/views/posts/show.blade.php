@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header p-3 w-100 d-flex">
                    @if($post->user->icon_image == null)
                        <img src="{{ '/assets/img/itWz22pzRoBOwTB2Hz1qYGuKvbfvRXaCB94gzuf7.jpeg' }}" class="rounded-circle" width="50" height="50">
                    @else
                        <img src="{{ $post->user->icon_image }}" class="rounded-circle" width="50" height="50">
                    @endif
                    <div class="ml-2 d-flex flex-column">
                        <a href ="{{ url('users/' .$post->user->id) }}" class="text-secondary">{!! nl2br(e(str_limit($post->user->name, 20))) !!}</a>
                    </div>
                    <div class="d-flex justify-content-end flex-grow-1">
                        <p class="mb-0 text-secondary">{{ $post->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                
                <div class="ml-4 d-flex flex-column mt-4">
                    <h5 class ="border-bottom pb-1">タイトル</h5>
                </div>
                <div class="card-body ml-3">
                    {!! nl2br(e($post->title)) !!}
                </div>
                
                <div class="ml-4 d-flex flex-column mt-4">
                    <h5 class ="border-bottom pb-1">参考書・教材</h5>
                </div>
                <div class="card-body ml-3">
                    {!! nl2br(e($post->study_book)) !!}
                </div>
                
                <div class="ml-4 d-flex flex-column mt-4">
                    <h5 class ="border-bottom pb-1">勉強法</h5>
                </div>
                <div class="card-body ml-3">
                    {!! nl2br(e($post->body)) !!}
                </div>
                
                <div class="ml-4 d-flex flex-column mt-4">
                    <h5 class ="border-bottom pb-1">成果</h5>
                </div>
                <div class="card-body ml-3">
                    {!! nl2br(e($post->result)) !!}
                </div>
                
                <div class="card-footer py-1 d-flex justify-content-end bg-white">
                    @if ($post->user->id === Auth::user()->id)
                        <div class="dropdown mr-3 d-flex align-items-center">
                            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-fw"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <form method="POST" action="{{ url('posts/' .$post->id) }}" class="mb-0">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ url('posts/' .$post->id .'/edit') }}" class="dropdown-item">編集</a>
                                    <button type="submit" class="dropdown-item del-btn">削除</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="mr-3 d-flex align-items-center">
                        <a href="{{ url('posts/' .$post->id) }}"><i class="far fa-comment fa-fw"></i></a>
                        <p class="mb-0 text-secondary">{{ count($post->comment) }}</p>
                    </div>

                    <div class="d-flex align-items-center">
                        @if (!in_array($user->id, array_column($post->like->toArray(), 'user_id'), TRUE))
                            <form method="POST" action="{{ url('likes/') }}" class="mb-0">
                                @csrf

                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <button type="submit" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                            </form>
                        @else
                            <form method="POST" action="{{ url('likes/' .array_column($post->like->toArray(), 'id', 'user_id')[$user->id]) }}" class="mb-0">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" class="btn p-0 border-0 text-danger"><i class="fas fa-heart fa-fw"></i></button>
                            </form>
                        @endif
                        <p class="mb-0 text-secondary">{{ count($post->like) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <ul class="list-group">
                @forelse ($comments as $comment)
                    <li class="list-group-item">
                        <div class="py-3 w-100 d-flex">
                            @if($comment->user->icon_image == null)
                                <img src="{{ '/assets/img/itWz22pzRoBOwTB2Hz1qYGuKvbfvRXaCB94gzuf7.jpeg' }}" class="rounded-circle" width="50" height="50">
                            @else
                                <img src="{{ $comment->user->icon_image }}" class="rounded-circle" width="50" height="50">
                            @endif
                            <div class="ml-2 d-flex flex-column">
                               
                               <a href="{{ url('users/' .$comment->user->id) }}" class="text-secondary">{!! nl2br(e(str_limit($comment->user->name, 20))) !!}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="py-3">
                            {!! nl2br(e($comment->text)) !!}
                        </div>
                    </li>
                @empty
                    <li class="list-group-item">
                        <p class="mb-0 text-secondary">コメント</p>
                    </li>
                @endforelse
                <li class="list-group-item">
                    <div class="py-3">
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf

                            <div class="form-group row mb-0">
                                <div class="col-md-12 p-3 w-100 d-flex">
                                    @if($user->icon_image == null)
                                        <img src="{{ '/assets/img/itWz22pzRoBOwTB2Hz1qYGuKvbfvRXaCB94gzuf7.jpeg' }}" class="rounded-circle" width="50" height="50">
                                    @else
                                        <img src="{{ $user->icon_image }}" class="rounded-circle" width="50" height="50">
                                    @endif
                                    <div class="ml-2 d-flex flex-column">
                                        <p class="mb-0">{!! nl2br(e(str_limit($user->name, 20))) !!}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="2">{{ old('text') }}</textarea>

                                    @error('text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mt-4">
                                <div class="d-flex justify-content-center col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        投稿
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
