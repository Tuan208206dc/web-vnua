@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<main class="container page-content">
    <section class="post-form-section">
        <h2 class="section-title">Đặt lại mật khẩu</h2>

        <div class="post-card">
            <p class="form-description">
                Hãy nhập mật khẩu mới cho tài khoản của bạn.
            </p>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}"
                  method="POST" class="post-form">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $email) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu mới</label>
                    <input type="password" name="password"
                           id="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Xác nhận mật khẩu mới
                    </label>
                    <input type="password" name="password_confirmation"
                           id="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button add-button">
                        Xác nhận đổi mật khẩu
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
