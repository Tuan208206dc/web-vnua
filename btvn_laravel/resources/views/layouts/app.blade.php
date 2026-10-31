<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Góc Công Nghệ')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #263238;
            background: #f5f7fa;
            line-height: 1.7;
        }

        a {
            color: #1769aa;
            text-decoration: none;
        }

        a:hover {
            color: #0b3d66;
        }

        .container {
            width: 90%;
            max-width: 1150px;
            margin: auto;
        }

        /* Thanh dieu huong */
        .navbar {
            background: #17324d;
            color: white;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 18px 0;
            gap: 12px;
        }

        .logo {
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        .logo:hover {
            color: #e7f1f8;
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 22px;
        }

        .menu a {
            color: white;
        }

        .menu a:hover {
            color: #b9d9f0;
        }

        .user-name {
            color: white;
            font-size: 14px;
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            background: #d9534f;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-button:hover {
            background: #c9302c;
        }

        /* Phan gioi thieu */
        .hero {
            background: linear-gradient(135deg, #17324d, #2878a5);
            color: white;
            padding: 48px 0;
            margin-bottom: 30px;
        }

        .hero h1 {
            font-size: 36px;
            margin: 0 0 10px;
        }

        .hero p {
            max-width: 700px;
            margin: 0;
            color: #e7f1f8;
        }

        /* Noi dung trang */
        .page-content {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(250px, 1fr);
            gap: 25px;
            align-items: start;
            margin-bottom: 40px;
        }

        .section-title {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #1769aa;
        }

        .post-card,
        .sidebar-box {
            background: white;
            padding: 22px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .post-card h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .post-meta {
            color: #77838f;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .post-excerpt {
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .post-content {
            margin-top: 15px;
        }

        .post-image {
            display: block;
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .edit-post-image {
            max-width: 300px;
            max-height: 250px;
            object-fit: cover;
        }

        .read-more {
            display: inline-block;
            margin-top: 8px;
            font-weight: bold;
        }

        .post-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
        }

        .post-actions form {
            margin: 0;
        }

        .sidebar-box h3 {
            margin-top: 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #e1e7ed;
        }

        .sidebar-box ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .empty-message {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        /* Form dang nhap, dang ky, bai viet */
        .post-form-section {
            width: 100%;
            max-width: 750px;
            margin: 30px auto 40px;
        }

        .post-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-description {
            color: #77838f;
            font-size: 14px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: bold;
            color: #263238;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccd5df;
            border-radius: 6px;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1769aa;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        /* Cac nut chuc nang */
        .action-button {
            display: inline-block;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .action-button:hover {
            color: white;
        }

        .add-button {
            background: #1769aa;
        }

        .add-button:hover {
            background: #0b3d66;
        }

        .cancel-button {
            background: #77838f;
        }

        .cancel-button:hover {
            background: #59636d;
        }

        .view-button {
            background: #2878a5;
        }

        .edit-button {
            background: #e0a126;
        }

        .delete-button {
            background: #d9534f;
        }

        .success-message {
            padding: 12px 16px;
            margin-bottom: 15px;
            background: #e4f5e9;
            color: #237a3b;
            border: 1px solid #b5dfc1;
            border-radius: 6px;
        }

        .error-message {
            padding: 12px 16px;
            margin-bottom: 15px;
            background: #fde8e8;
            color: #b42318;
            border: 1px solid #f5b5b5;
            border-radius: 6px;
        }

        .error-message p {
            margin: 4px 0;
        }

        .error-message ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        .field-error {
            color: #b42318;
            font-size: 13px;
            margin: 0;
        }

        /* Chan trang */
        .footer {
            background: #17324d;
            color: #e7edf3;
            padding: 25px 0;
            text-align: center;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-content {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 28px;
            }

            .nav-content {
                align-items: flex-start;
                flex-direction: column;
            }

            .menu {
                gap: 12px;
            }

            .post-form-section {
                margin-top: 15px;
            }
        }
        
/* Thong bao he thong */
.system-message {
    width: 90%;
    max-width: 1150px;
    margin: 20px auto;
    padding: 14px 18px;
    border-radius: 8px;
    font-size: 14px;
}

.system-success {
    background: #e4f5e9;
    color: #237a3b;
    border: 1px solid #b5dfc1;
}

.system-error {
    background: #fde8e8;
    color: #b42318;
    border: 1px solid #f5b5b5;
}

    </style>

    @yield('styles')
</head>

<body>

    <nav class="navbar">
        <div class="container nav-content">

            <a href="{{ route('home') }}" class="logo">
                Góc Công Nghệ
            </a>

            <div class="menu">
                <a href="{{ route('home') }}">Trang chủ</a>

                <a href="{{ route('post.index') }}">Bài viết</a>

                @auth
                    <a href="{{ route('post.create') }}">Thêm bài viết</a>

                    <span class="user-name">
                        Xin chào, {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}"
                          method="POST"
                          class="logout-form">
                        @csrf

                        <button type="submit" class="logout-button">
                            Đăng xuất
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Đăng nhập</a>

                    <a href="{{ route('register') }}">Đăng ký</a>
                @endauth
            </div>

        </div>
    </nav>
    </nav>

    @if (session('success'))
        <div class="system-message system-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="system-message system-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

    @include('includes.footer')

    @yield('scripts')

</body>
</html>
