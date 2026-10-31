@extends('layouts.app')

@section('title', 'Chi tiết bài viết - Góc Công Nghệ')

@section('content')

<main class="container page-content">

    <section class="post-detail">
        <h2 class="section-title">Chi tiết bài viết</h2>

        <article class="post-card">

            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}"
                     alt="{{ $post->title }}"
                     class="post-image">
            @endif

            <div class="post-meta">
                Bài viết #{{ $post->id }}
                | Tác giả: {{ $post->user->name ?? 'Chưa xác định' }}

                @if ($post->created_at)
                    | Ngày đăng: {{ $post->created_at->format('d/m/Y') }}
                @endif
            </div>

            <h1>{{ $post->title }}</h1>

            <div class="post-excerpt post-content">
                {{ $post->content }}
            </div>

            <div class="post-actions">

                <a class="read-more"
                   href="{{ route('post.index') }}">
                    ← Danh sách bài viết
                </a>

                @if (auth()->check() && auth()->id() == $post->user_id)

                    <a class="action-button edit-button"
                       href="{{ route('post.edit', $post->id) }}">
                        Sửa bài viết
                    </a>

                    <form action="{{ route('post.destroy', $post->id) }}"
                          method="POST"
                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này không?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="action-button delete-button">
                            Xóa bài viết
                        </button>
                    </form>

                @endif

            </div>

        </article>
    </section>

</main>

@endsection
