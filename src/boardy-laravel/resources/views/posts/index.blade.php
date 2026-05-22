@extends('layouts.app')

@section('title', 'Все посты')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Все посты</h1>
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Создать пост</a>
        @endauth
    </div>

    <div id="posts-feed">
        @forelse($posts as $post)
            <div class="card mb-3" data-id="{{ $post->id }}">
                <div class="card-body">
                    <h3><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                    <p>{{ Str::limit($post->body, 200) }}</p>
                    <div class="text-muted small">
                        Автор: {{ $post->author->name }} | {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <p>Постов пока нет.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection

@section('scripts')
<script>
    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function prependPost(post) {
        const feed = document.getElementById('posts-feed');
        if (!feed) return;

        const el = document.createElement('div');
        el.className = 'card mb-3';
        el.setAttribute('data-id', post.id);
        el.innerHTML = `
            <div class="card-body">
                <h3><a href="/posts/${post.id}">${escapeHtml(post.title)}</a></h3>
                <p>${escapeHtml(post.body)}</p>
                <div class="text-muted small">
                    Автор: ${escapeHtml(post.author)} | только что
                </div>
            </div>
        `;
        feed.prepend(el);
    }

    function connectWebSocket() {
        const protocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
        const host = 'api.pablo52.ai-info.ru';
        const wsUrl = `${protocol}//${host}/ws`;

        const ws = new WebSocket(wsUrl);

        ws.onopen = () => {
            console.log('WebSocket connected');
        };

        ws.onmessage = (event) => {
            try {
                const data = JSON.parse(event.data);
                if (data.type === 'new_post') {
                    prependPost(data.post);
                }
            } catch (e) {
                console.error('Error parsing message:', e);
            }
        };

        ws.onclose = () => {
            console.log('WebSocket disconnected, reconnecting in 3 seconds...');
            setTimeout(connectWebSocket, 3000);
        };

        ws.onerror = (error) => {
            console.error('WebSocket error:', error);
        };
    }

    if (document.getElementById('posts-feed')) {
        connectWebSocket();
    }
</script>
@endsection
