# Góc Công Nghệ

Website blog cá nhân được xây dựng bằng Laravel và Blade, dùng để chia sẻ kiến thức lập trình và công nghệ thông tin.

## 1. Công nghệ sử dụng

- PHP 8
- Laravel 9
- Blade Template
- Bootstrap 4
- MySQL

## 2. Chức năng

- Hiển thị danh sách bài viết trên trang chủ.
- Hiển thị tiêu đề và nội dung bài viết.
- Xem chi tiết từng bài viết.
- Sử dụng layout chung cho menu và footer.
- Sử dụng các directive Blade như `@include`, `@extends`,
  `@section`, `@yield`, `@if` và `@foreach`.
- Có dữ liệu mẫu cho bảng người dùng, bài viết và bình luận.

## 3. Yêu cầu môi trường

- PHP 8 trở lên, tương thích với Laravel 9.
- Composer.
- MySQL.
- XAMPP hoặc môi trường chạy PHP tương đương.

## 4. Cách cài đặt

### Bước 1: Tải mã nguồn

Clone repository về máy và mở Terminal trong thư mục dự án.

### Bước 2: Cài đặt thư viện

```bash
composer install
```

### Bước 3: Tạo file cấu hình

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Nếu đã có file `.env`, không cần tạo lại.

### Bước 4: Tạo cơ sở dữ liệu

Tạo database MySQL có tên:

`btvn_laravel`

Kiểm tra thông tin kết nối trong file `.env` cho phù hợp với máy đang sử dụng.

### Bước 5: Tạo khóa ứng dụng

```bash
php artisan key:generate
```

### Bước 6: Tạo bảng và dữ liệu mẫu

```bash
php artisan migrate --seed
```

Lệnh này chạy các migration chưa được thực hiện và gọi seeder để tạo dữ liệu mẫu.

### Bước 7: Chạy website

```bash
php artisan serve
```

Mở trình duyệt tại:

http://127.0.0.1:8000

## 5. Tác giả

Bài tập thực hành Laravel - Góc Công Nghệ.
