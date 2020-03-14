<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>{{ $website->uuid }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>
<div class="container-md">
    @foreach ($entries as $entry)
    <article>
        <h2>
            {{ $entry->title }}
            @if (!$entry->userMark)
            <a href="{{ route('changelog.markAsRead', ['id' => $entry->id]) }}" style="color: red;"><small>(new)</small></a>
            @endif
        </h2>
        <div class="row">
            <div class="col-md-4">
                <h5 style="color: {{ $entry->category->color }}">{{ $entry->category->name }}</h5>
            </div>
            <div class="col-md-4">
                {{ $entry->published_at }}
            </div>
        </div>
        <p>{{ $entry->content }}</p>
        <hr>
    </article>
    @endforeach
</div>
</body>

</html>
