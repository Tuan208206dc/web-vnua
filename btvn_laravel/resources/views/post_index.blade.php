<h1>Danh sach bai viet</h1>

@foreach($posts as $post)
    <p>
        ID: {{ $post->id }} -
        Title: {{ $post->title }}
        <a href="{{ url('/post/' . $post->id) }}">Xem chi tiet</a>
    </p>
@endforeach
