@extends('layouts.app')

@section('title', 'Đăng ký tài khoản')

@section('content')
<main class="container page-content">
    <section class="post-form-section">
        <h2 class="section-title">Đăng ký tài khoản</h2>

        <div class="post-card">
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="post-form">
                @csrf

                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password"
                           id="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation"
                           id="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button add-button">
                        Đăng ký
                    </button>

                    <a href="{{ route('login') }}"
                       class="action-button cancel-button">
                        Đã có tài khoản? Đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
