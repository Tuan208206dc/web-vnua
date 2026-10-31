@extends('layouts.app')

@section('title', 'Trang chủ - Góc Công Nghệ')

@section('content')

<section class="hero">
    <div class="container">
        <h1>Chào mừng đến với Góc Công Nghệ</h1>
        <p>
            Nơi chia sẻ kiến thức về công nghệ, lập trình,
            website và những xu hướng công nghệ mới.
        </p>
    </div>
</section>

<main class="container page-content">

    <section>
        <h2 class="section-title">Bài viết mới nhất</h2>

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

                        @if ($post->created_at)
                            - Tác giả:
                            {{ $post->user ? $post->user->name : 'Chưa xác định' }} 
                            | Ngày đăng:
                            {{ $post->created_at->format('d/m/Y') }}
                        @endif
                    </div>

                    <div class="post-excerpt">
                        {{ \Illuminate\Support\Str::limit($post->content, 220) }}
                    </div>

                    <a
                        class="read-more"
                        href="{{ route('post.show', $post->id) }}"
                    >
                        Đọc tiếp →
                    </a>
                </article>
            @endforeach
        @endif
    </section>

    <aside>
        <div class="sidebar-box">
            <h3>Giới thiệu</h3>
            <p>
                Góc Công Nghệ là website chia sẻ kiến thức,
                kinh nghiệm lập trình và thông tin công nghệ
                dành cho những người yêu thích công nghệ.
            </p>
        </div>

        <div class="sidebar-box">
            <h3>Chủ đề nổi bật</h3>
            <ul>
                <li>Lập trình PHP và Laravel</li>
                <li>Phát triển website</li>
                <li>Cơ sở dữ liệu</li>
                <li>Công nghệ thông tin</li>
            </ul>
        </div>

        <div class="sidebar-box">
            <h3>Bài viết gần đây</h3>

            @if ($recentPosts->isEmpty())
                <p>Chưa có bài viết gần đây.</p>
            @else
                <ul>
                    @foreach ($recentPosts as $recentPost)
                        <li>
                            <a href="{{ route('post.show', $recentPost->id) }}">
                                {{ $recentPost->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </aside>

</main>

@endsection
