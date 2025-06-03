<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ $page->name }}</title>
  <link rel="stylesheet" href="{{ asset('reveal.js/dist/reveal.css') }}">
  <link rel="stylesheet" href="{{ asset('reveal.js/dist/theme/black.css') }}" id="theme">
</head>
<body>

  <div class="reveal">
    <div class="slides">
        <h1> xdcdncdjc</h1>
      {!! $page->html !!}
    </div>
  </div>

  <script src="{{ asset('reveal.js/dist/reveal.js') }}"></script>
  <script>
    Reveal.initialize();
  </script>

</body>
</html>
