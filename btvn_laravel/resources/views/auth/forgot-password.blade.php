@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<main class="container page-content">
    <section class="post-form-section">
        <h2 class="section-title">Quên mật khẩu</h2>

        <div class="post-card">
            <p class="form-description">
                Nhập địa chỉ email đã đăng ký. Chúng tôi sẽ gửi cho bạn
                liên kết để đặt lại mật khẩu.
            </p>

            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.email') }}"
                  method="POST" class="post-form">
                @csrf

                <div class="form-group">
                    <label for="email">Địa chỉ email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button add-button">
                        Gửi liên kết đặt lại mật khẩu
                    </button>

                    <a href="{{ route('login') }}"
                       class="action-button cancel-button">
                        Quay lại đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
