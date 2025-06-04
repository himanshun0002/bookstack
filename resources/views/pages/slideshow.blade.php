<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($page->name); ?> - Slideshow</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            overflow: hidden;
        }

        .slideshow-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 40px;
            box-sizing: border-box;
            background: #000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .slide.active {
            display: flex;
            opacity: 1;
        }

        .slide-content {
            max-width: 80%;
            max-height: 80%;
            overflow: auto;
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .slide h2 {
            color: #42affa;
            margin-top: 0;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .slide p {
            font-size: 24px;
            line-height: 1.6;
            margin-bottom: 1em;
        }

        .controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: flex;
            gap: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px 20px;
            border-radius: 30px;
        }

        .control-button {
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            transition: background-color 0.2s;
        }

        .control-button:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .slide-number {
            color: #fff;
            font-size: 16px;
            margin: 0 20px;
        }

        .exit-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            z-index: 1000;
            text-decoration: none;
        }

        .exit-button:hover {
            background: rgba(0, 0, 0, 0.9);
        }
    </style>
</head>
<body>
    <div class="slideshow-container">
        <?php foreach ($sections as $index => $section): ?>
            <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                <div class="slide-content">
                    <?php echo $section; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="controls">
        <button class="control-button" id="prevButton">←</button>
        <span class="slide-number">Slide <span id="current-slide">1</span> of <span id="total-slides"><?php echo count($sections); ?></span></span>
        <button class="control-button" id="nextButton">→</button>
    </div>

    <a href="{{ url('/books/' . $page->book->slug . '/page/' . $page->slug) }}" class="exit-button">Exit Slideshow</a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const totalSlides = slides.length;
            const currentSlideElement = document.getElementById('current-slide');
            let currentSlide = 0;
            let slideInterval;

            function showSlide(index) {
                // Remove active class from all slides
                slides.forEach(slide => slide.classList.remove('active'));
                
                // Add active class to current slide
                slides[index].classList.add('active');
                
                // Update slide number
                currentSlideElement.textContent = index + 1;
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            }

            function previousSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(currentSlide);
            }

            function startAutoSlide() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                }
                slideInterval = setInterval(nextSlide, 3000);
            }

            function stopAutoSlide() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                }
            }

            // Button click handlers
            document.getElementById('nextButton').addEventListener('click', function() {
                stopAutoSlide();
                nextSlide();
                startAutoSlide();
            });

            document.getElementById('prevButton').addEventListener('click', function() {
                stopAutoSlide();
                previousSlide();
                startAutoSlide();
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    stopAutoSlide();
                    nextSlide();
                    startAutoSlide();
                } else if (e.key === 'ArrowLeft') {
                    stopAutoSlide();
                    previousSlide();
                    startAutoSlide();
                } else if (e.key === 'Escape') {
                    window.location.href = '{{ url('/books/' . $page->book->slug . '/page/' . $page->slug) }}';
                }
            });

            // Touch navigation
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            document.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                const swipeThreshold = 50;
                
                if (touchEndX < touchStartX - swipeThreshold) {
                    stopAutoSlide();
                    nextSlide();
                    startAutoSlide();
                } else if (touchEndX > touchStartX + swipeThreshold) {
                    stopAutoSlide();
                    previousSlide();
                    startAutoSlide();
                }
            });

            // Start automatic slideshow
            startAutoSlide();
        });
    </script>
</body>
</html> 