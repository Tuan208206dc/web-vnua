<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Goc Cong Nghe - @yield('title', 'Trang chu')</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

    @include('includes.navbar')

    <div class="container mt-4">
        @yield('content')
    </div>

    @include('includes.footer')

</body>
</html>
