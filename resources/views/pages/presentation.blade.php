<?php
// No need to extract sections here as they're passed from the route
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($page->name); ?> - Slides</title>
    <style>
        body {
            background: #f5f5f5;
            color: #333;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            padding: 20px;
            margin: 0;
        }

        .slide {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px auto;
            min-height: 200px;
            width: calc(100% - 80px);
            max-width: 720px;
        }

        .slide h2 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #42affa;
            padding-bottom: 10px;
        }

        .slide p {
            line-height: 1.6;
            margin-bottom: 1em;
            font-size: 18px;
        }

        .page-title {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .slide-number {
            color: #42affa;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        .slideshow-button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            background: #42affa;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.2s;
            text-decoration: none;
            text-align: center;
        }

        .slideshow-button:hover {
            background: #1a9ff0;
        }

        .back-button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            background: #666;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.2s;
            text-decoration: none;
            text-align: center;
        }

        .back-button:hover {
            background: #555;
        }
    </style>
</head>
<body>

<h1 class="page-title"><?php echo htmlspecialchars($page->name); ?> - Slides</h1>

<div class="button-container">
    <a href="{{ url('/books/' . $page->book->slug . '/page/' . $page->slug) }}" class="back-button">Back to Page</a>
    <a href="{{ url('/pages/' . $page->id . '/slideshow') }}" class="slideshow-button">Start Slideshow</a>
</div>

<div class="slides-container">
    <?php foreach ($sections as $index => $section): ?>
        <div class="slide">
            <div class="slide-number">Slide <?php echo $index + 1; ?></div>
            <?php echo $section; ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
