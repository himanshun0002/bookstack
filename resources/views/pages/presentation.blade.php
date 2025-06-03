<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $page->name }} - Presentation</title>
    <link rel="stylesheet" href="{{ url('/reveal.js/dist/reveal.css') }}">
    <link rel="stylesheet" href="{{ url('/reveal.js/dist/theme/white.css') }}">
    <style>
        .reveal section { padding: 20px; }
    </style>
</head>
<body>
<div class="reveal">
    <div class="slides">
        {!! $page->html !!}
    </div>
</div>

<script src="{{ url('/reveal.js/dist/reveal.js') }}"></script>
<script>
    Reveal.initialize();
</script>

</body>
</html>
