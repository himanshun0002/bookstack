<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $page->name }} - Presentation</title>
    
    <!-- Reveal.js CSS -->
    <link rel="stylesheet" href="{{ url('/reveal.js/dist/reveal.css') }}">
    <link rel="stylesheet" href="{{ url('/reveal.js/dist/theme/black.css') }}">
    
    <!-- Reveal.js Plugins CSS -->
    <link rel="stylesheet" href="{{ url('/reveal.js/plugin/highlight/monokai.css') }}">
    
    <style>
        body { margin: 0; background: #191919; }
        .reveal { height: 100vh; }
        .reveal .slides section { 
            padding: 20px;
            height: 100vh;
            text-align: left !important;
        }
        .reveal .slides > section {
            width: 100%;
            height: 100%;
        }
        .reveal h2 { 
            color: #fff;
            margin-bottom: 30px;
            text-transform: none;
        }
        .reveal p {
            margin: 20px 0;
            line-height: 1.4;
        }
        .reveal pre {
            margin: 15px 0;
            width: 100%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        .reveal img {
            margin: 20px 0;
            max-height: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        .debug { 
            position: fixed; 
            top: 0; 
            left: 0; 
            background: rgba(0,0,0,0.8); 
            color: #fff;
            padding: 10px; 
            z-index: 9999; 
            border: 1px solid #333;
            font-size: 12px;
            font-family: monospace;
        }
        .reveal .progress { 
            color: #42affa;
        }
        .reveal .controls { 
            color: #42affa;
        }
        /* Ensure slides take full space */
        .reveal .slides > section,
        .reveal .slides > section > section {
            min-height: 100% !important;
            transform-style: flat !important;
        }
        /* Hide overflow to prevent seeing other slides */
        .reveal .slides {
            overflow: hidden !important;
        }
    </style>
</head>
<body>
    <!-- Debug output -->
    <div class="debug">
        <p>Page ID: {{ $page->id }}</p>
        <p>Page Name: {{ $page->name }}</p>
        <p>Has HTML: {{ !empty($page->html) ? 'Yes' : 'No' }}</p>
        <p>HTML Length: {{ strlen($page->html) }}</p>
        <p>Raw Content Preview: <pre>{{ substr($page->html, 0, 10000000) }}</pre></p>
    </div>

    <div class="reveal">
        <div class="slides">
            {!! $page->html !!}
        </div>
    </div>

    <!-- Reveal.js Scripts -->
    <script src="{{ url('/reveal.js/dist/reveal.js') }}"></script>
    <script src="{{ url('/reveal.js/plugin/zoom/zoom.js') }}"></script>
    <script src="{{ url('/reveal.js/plugin/notes/notes.js') }}"></script>
    <script src="{{ url('/reveal.js/plugin/search/search.js') }}"></script>
    <script src="{{ url('/reveal.js/plugin/markdown/markdown.js') }}"></script>
    <script src="{{ url('/reveal.js/plugin/highlight/highlight.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Reveal.initialize({
                // Display configuration
                width: '100%',
                height: '100%',
                margin: 0,
                minScale: 0.2,
                maxScale: 1.5,
                
                // Controls
                controls: true,
                controlsTutorial: true,
                controlsLayout: 'bottom-right',
                controlsBackArrows: 'faded',
                
                // Navigation
                hash: true,
                slideNumber: 'c/t',
                overview: false, // Disable overview
                center: true,
                touch: true,
                loop: false,
                rtl: false,
                navigationMode: 'linear', // Force linear navigation
                
                // Presentation features
                progress: true,
                autoPlayMedia: true,
                autoSlide: 0,
                
                // View
                display: 'block',
                viewDistance: 1, // Only load current slide
                preloadIframes: false, // Don't preload iframes
                
                // Transition
                transition: 'slide', // or try: 'fade', 'convex', 'concave'
                transitionSpeed: 'default',
                backgroundTransition: 'fade',
                
                // Plugins
                plugins: [ 
                    RevealZoom,
                    RevealNotes,
                    RevealSearch,
                    RevealMarkdown,
                    RevealHighlight
                ],
                
                // Plugin configurations
                highlight: {
                    highlightOnLoad: true,
                    escapeHTML: true
                },
                markdown: {
                    smartypants: true
                }
            });

            // Ensure only one slide is visible
            Reveal.addEventListener('ready', function() {
                // Hide all slides except the current one
                var slides = document.querySelectorAll('.reveal .slides > section');
                slides.forEach(function(slide) {
                    if (!slide.classList.contains('present')) {
                        slide.style.display = 'none';
                    }
                });
            });

            // Handle slide changes
            Reveal.addEventListener('slidechanged', function(event) {
                var slides = document.querySelectorAll('.reveal .slides > section');
                slides.forEach(function(slide) {
                    if (slide === event.currentSlide) {
                        slide.style.display = 'block';
                    } else {
                        slide.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
