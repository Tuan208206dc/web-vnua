@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<main class="container page-content">
    <section class="post-form-section">
        <h2 class="section-title">Đăng nhập</h2>

        <div class="post-card">
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

            <form action="{{ route('login.store') }}"
                  method="POST" class="post-form">
                @csrf

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

                <div>
                    <a href="{{ route('password.request') }}">
                        Quên mật khẩu?
                    </a>
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button add-button">
                        Đăng nhập
                    </button>

                    <a href="{{ route('register') }}"
                       class="action-button cancel-button">
                        Chưa có tài khoản? Đăng ký
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
