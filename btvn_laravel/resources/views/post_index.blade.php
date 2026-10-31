@extends('layouts.app')

@section('title', 'Danh sách bài viết - Góc Công Nghệ')

@section('content')

<main class="container page-content">

    <section class="post-list">
        <h2 class="section-title">Danh sách bài viết</h2>

        <div class="post-list-top">
            <p>Quản lý các bài viết trên Góc Công Nghệ.</p>

            @auth
                <a href="{{ route('post.create') }}" class="action-button add-button">
                    + Thêm bài viết
                </a>
            @endauth
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if ($posts->isEmpty())
            <div class="empty-message">
                Hiện chưa có bài viết nào.
            </div>
        @else
            @foreach ($posts as $post)
                <article class="post-card">

                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}"
                             alt="{{ $post->title }}"
                             class="post-image">
                    @endif

                    <h3>
                        <a href="{{ route('post.show', $post->id) }}">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <div class="post-meta">
                        Bài viết #{{ $post->id }}
                        | Tác giả:
                        {{ $post->user->name ?? 'Chưa xác định' }}

                        @if ($post->created_at)
                            | Ngày đăng:
                            {{ $post->created_at->format('d/m/Y') }}
                        @endif
                    </div>

                    <div class="post-excerpt">
                        {{ \Illuminate\Support\Str::limit($post->content, 220) }}
                    </div>

                    <div class="post-actions">

                        <a href="{{ route('post.show', $post->id) }}"
                           class="action-button view-button">
                            Xem chi tiết
                        </a>

                        @if (auth()->check() && auth()->id() == $post->user_id)

                            <a href="{{ route('post.edit', $post->id) }}"
                               class="action-button edit-button">
                                Sửa
                            </a>

                            <form action="{{ route('post.destroy', $post->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này không?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-button delete-button">
                                    Xóa
                                </button>
                            </form>

                        @endif

                    </div>

                </article>
            @endforeach
        @endif
    </section>

</main>

@endsection
