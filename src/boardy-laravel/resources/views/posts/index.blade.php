@extends('layouts.app')

@section('title', 'Все посты')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Все посты</h1>
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Создать пост</a>
        @endauth
    </div>

    @forelse($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h3><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                <p>{{ Str::limit($post->body, 200) }}</p>
                <div class="text-muted small">
                    Автор: {{ $post->author->name ?? 'unknown' }} | {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    @empty
        <p>Постов пока нет.</p>
    @endforelse

    {{ $posts->links() }}
@endsection
