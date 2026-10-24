
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
</head>
<body>
    <h1>Chi tiết bài viết</h1>

    @if ($post)
        <p><strong>ID:</strong> {{ $post->id }}</p>
        <p><strong>ID nguoi dang:</strong> {{ $post->user_id }}</p>
        <p><strong>Tieu de:</strong> {{ $post->title }}</p>
        <p><strong>Noi dung:</strong> {{ $post->content }}</p>
        <p><strong>Ngay tao:</strong> {{ $post->created_at }}</p>
        <p><strong>Ngay cap nhat:</strong> {{ $post->updated_at }}</p>
    @else
        <p>Không tìm thấy bài viết có ID này!</p>
    @endif

    <a href="{{ url('/') }}">Quay về trang chủ</a>
</body>
</html>
