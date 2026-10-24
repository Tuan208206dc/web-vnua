@extends('layouts.app')

@section('title', 'Trang chủ - Góc Công Nghệ')

@section('content')

    <div class="p-5 mb-5 text-white rounded"
         style="background: linear-gradient(120deg, #173b6c, #3977a8);">

        <p class="text-uppercase mb-2">Blog cá nhân</p>

        <h1 class="font-weight-bold">Góc Công Nghệ</h1>

        <p class="mb-0">
            Chia sẻ kiến thức lập trình, phát triển website
            và kinh nghiệm học tập của sinh viên IT.
        </p>
    </div>

    <div class="row">

        <div class="col-md-8">

            <h3 class="font-weight-bold mb-4">
                Bài viết mới nhất
            </h3>

            @if(count($posts) > 0)

                @foreach($posts as $post)

                    <div class="card mb-4">
                        <div class="card-body p-4">

                            <span class="badge badge-primary mb-2">
                                CÔNG NGHỆ
                            </span>

                            <h4 class="font-weight-bold">
                                <a href="{{ url('/post/' . $post->id) }}"
                                   class="text-dark">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <p class="text-muted">
                                Bài viết số {{ $post->id }}
                            </p>

                            <p>
                                {{ $post->content }}
                            </p>

                            <a href="{{ url('/post/' . $post->id) }}"
                               class="btn btn-outline-primary">
                                Đọc tiếp →
                            </a>

                        </div>
                    </div>

                @endforeach

            @else

                <div class="alert alert-info">
                    Hiện tại chưa có bài viết nào.
                </div>

            @endif

        </div>

        <div class="col-md-4">

            <div class="card mb-4">
                <div class="card-body p-4">

                    <h4 class="font-weight-bold mb-3">
                        Giới thiệu
                    </h4>

                    <p>
                        Góc Công Nghệ là nơi chia sẻ kiến thức
                        về lập trình, website và cơ sở dữ liệu.
                    </p>

                    <p class="mb-0">
                        Nội dung hướng đến những người mới học
                        công nghệ thông tin.
                    </p>

                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body p-4">

                    <h4 class="font-weight-bold mb-3">
                        Chủ đề
                    </h4>

                    <ul class="list-unstyled mb-0">
                        <li class="border-bottom py-2">
                            PHP và Laravel
                        </li>

                        <li class="border-bottom py-2">
                            Thiết kế website
                        </li>

                        <li class="border-bottom py-2">
                            Cơ sở dữ liệu
                        </li>

                        <li class="py-2">
                            Kinh nghiệm học IT
                        </li>
                    </ul>

                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">

                    <h4 class="font-weight-bold mb-3">
                        Bài viết gần đây
                    </h4>

                    @if(count($posts) > 0)

                        @foreach($posts as $post)

                            <p class="border-bottom pb-2">
                                <a href="{{ url('/post/' . $post->id) }}">
                                    {{ $post->title }}
                                </a>
                            </p>

                        @endforeach

                    @else

                        <p>Chưa có bài viết.</p>

                    @endif

                </div>
            </div>

        </div>

    </div>

@endsection
