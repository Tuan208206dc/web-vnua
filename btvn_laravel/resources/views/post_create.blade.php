@extends('layouts.app')

@section('title', 'Thêm bài viết - Góc Công Nghệ')

@section('content')

<main class="container page-content">

    <section class="post-form-section">
        <h2 class="section-title">Thêm bài viết mới</h2>

        <div class="post-card">
            <p class="form-description">
                Nhập thông tin bên dưới để đăng bài viết mới lên Góc Công Nghệ.
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

            <form action="{{ route('post.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="post-form">

                @csrf

                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>

                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           placeholder="Nhập tiêu đề bài viết"
                           maxlength="50"
                           required>
                </div>

                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>

                    <textarea name="content"
                              id="content"
                              rows="10"
                              placeholder="Nhập nội dung bài viết"
                              required>{{ old('content') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Ảnh bài viết</label>

                    <input type="file"
                           name="image"
                           id="image"
                           accept="image/jpeg,image/png,image/webp">

                    <p class="form-description">
                        Chọn ảnh JPG, JPEG, PNG hoặc WEBP.
                        Dung lượng tối đa 2 MB.
                    </p>

                    @error('image')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button add-button">
                        Thêm bài viết
                    </button>

                    <a href="{{ route('post.index') }}"
                       class="action-button cancel-button">
                        Hủy
                    </a>
                </div>

            </form>
        </div>
    </section>

</main>

@endsection
