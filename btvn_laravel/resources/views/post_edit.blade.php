@extends('layouts.app')

@section('title', 'Sửa bài viết - Góc Công Nghệ')

@section('content')

<main class="container page-content">

    <section class="post-form-section">
        <h2 class="section-title">Sửa bài viết</h2>

        <div class="post-card">

            <p class="form-description">
                Cập nhật thông tin bài viết bên dưới rồi nhấn nút lưu thay đổi.
            </p>

            @if ($errors->any())
                <div class="error-message">
                    <strong>Vui lòng kiểm tra lại thông tin:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('post.update', $post->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="post-form">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>

                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $post->title) }}"
                           placeholder="Nhập tiêu đề bài viết"
                           maxlength="50"
                           required>

                    @error('title')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>

                    <textarea name="content"
                              id="content"
                              rows="10"
                              placeholder="Nhập nội dung bài viết"
                              required>{{ old('content', $post->content) }}</textarea>

                    @error('content')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Ảnh hiện tại</label>

                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}"
                             alt="Ảnh bài viết"
                             class="edit-post-image">
                    @else
                        <p>Bài viết chưa có ảnh.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image">Chọn ảnh mới (không bắt buộc)</label>

                    <input type="file"
                           name="image"
                           id="image"
                           accept="image/jpeg,image/png,image/webp">

                    <p class="form-description">
                        Chấp nhận JPG, JPEG, PNG, WEBP. Dung lượng tối đa 2 MB.
                        Nếu không chọn ảnh mới, ảnh hiện tại sẽ được giữ lại.
                    </p>

                    @error('image')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button add-button">
                        Lưu thay đổi
                    </button>

                    <a href="{{ route('post.show', $post->id) }}"
                       class="action-button cancel-button">
                        Hủy
                    </a>

                    <a href="{{ route('post.index') }}"
                       class="action-button view-button">
                        Danh sách bài viết
                    </a>
                </div>

            </form>
        </div>
    </section>

</main>

@endsection
