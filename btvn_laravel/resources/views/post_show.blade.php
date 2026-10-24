@extends('layouts.app')

@section('title', 'Chi tiết bài viết - Góc Công Nghệ')

@section('content')

    @if($post)
        <div class="card">
            <div class="card-body">

                <h1>{{ $post->title }}</h1>

                <hr>

                <p>{{ $post->content }}</p>

                <a href="{{ url('/') }}" class="btn btn-primary">
                    Quay lại trang chủ
                </a>

            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Không tìm thấy bài viết.
        </div>

        <a href="{{ url('/') }}" class="btn btn-secondary">
            Quay lại trang chủ
        </a>
    @endif

@endsection
