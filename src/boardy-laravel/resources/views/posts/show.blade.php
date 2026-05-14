@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title">{{ $post->title }}</h1>
            <p class="card-text">{{ $post->body }}</p>
            <div class="text-muted small">
                Автор: {{ $post->author->name }} | {{ $post->created_at->diffForHumans() }}
            </div>
            @can('update', $post)
                <div class="mt-3">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary">✏️ Редактировать</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить пост?')">🗑️ Удалить</button>
                    </form>
                </div>
            @endcan
        </div>
    </div>

    <h3>Комментарии ({{ $post->comments->count() }})</h3>

    @forelse($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p class="card-text">{{ $comment->body }}</p>
                <div class="text-muted small">
                    {{ $comment->author->name }} | {{ $comment->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    @empty
        <p>Пока нет комментариев. Будьте первым!</p>
    @endforelse

    @auth
        <div class="card mt-4">
            <div class="card-body">
                <h5>Добавить комментарий</h5>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="mb-3">
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="3" placeholder="Ваш комментарий"></textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info mt-4">
            <a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.
        </div>
    @endauth
@endsection
