<html>
<head>
<title>Cool Blog Homepage</title>
</head>
<body>
<h1>Welcome to the homepage of my cool blog!</h1>
<a href="{{ url('/about') }}">About</a>
<p>Today is {{ date('j F Y') }}.</p>

<h2>Blog posts:</h2>
@foreach($posts as $post)
<p>{{$post->title}}</p>
@endforeach

@foreach($posts as $post)
    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
        <a href="{{ route('blog.show', ['id' => $post->id]) }}">Read more</a>
    </div>
@endforeach
</body>
</html>