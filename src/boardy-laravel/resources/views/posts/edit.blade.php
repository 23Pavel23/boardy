@extends('layouts.app')

@section('title', 'Редактировать пост')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Редактировать пост</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Текст поста</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="6" required>{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Отмена</a>
            </form>
        </div>
    </div>
@endsection
