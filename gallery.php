<?php require_once 'init.php'; ?>
<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Gallery - TripWise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0);
            backdrop-filter: blur(2px);
            min-height: calc(100vh - 80px);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            aspect-ratio: 4/3;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            color: white;
            padding: 1.5rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .image-overlay {
            transform: translateY(0);
        }

        .image-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .image-location {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .upload-section {
            background: linear-gradient(135deg, #5F8D7A, #7A9EB1);
            color: white;
            padding: 3rem 2rem;
            border-radius: 12px;
            text-align: center;
        }

        .upload-section h2 {
            margin-bottom: 1rem;
            color: white;
        }

        .upload-btn {
            background: #D4A574;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .upload-btn:hover {
            background: #c09565;
            transform: translateY(-2px);
        }

         /* Go to Top Button */
        .go-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #5F8D7A;
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            display: none;
            z-index: 1000;
        }

        .go-to-top:hover {
            background: #4a7a65;
            transform: translateY(-3px);
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #7A9EB1;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="gallery-container">
        <div class="page-header">
            <h1>Travel Inspiration Gallery</h1>
            <p>Discover breathtaking destinations through our community's eyes</p>
        </div>

        <div class="gallery-grid">
            <!-- Mountain Images -->
            <div class="gallery-item" data-category="mountains">
                <div class="gallery-image">
                    <img src="images/swizz-alps1.jpg" alt="swizz-alps" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Swiss Alps Adventure</div>
                    <div class="image-location">Switzerland</div>
                </div>
            </div>

            <div class="gallery-item" data-category="mountains">
                <div class="gallery-image">
                    <img src="images/mountain-high1.jpg" alt="mountain-high" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Rocky Mountain High</div>
                    <div class="image-location">Colorado, USA</div>
                </div>
            </div>

            <!-- Beach Images -->
            <div class="gallery-item" data-category="beaches">
                <div class="gallery-image">
                    <img src="images/tropical.jpg" alt="tropical-paradise" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Tropical Paradise</div>
                    <div class="image-location">Maldives</div>
                </div>
            </div>

            <div class="gallery-item" data-category="beaches">
                <div class="gallery-image">
                    <img src="images/sunset-beach.jpg" alt="sunset-beach" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Sunset Beach</div>
                    <div class="image-location">Bali, Indonesia</div>
                </div>
            </div>

            <!-- City Images -->
            <div class="gallery-item" data-category="cities">
                <div class="gallery-image">
                    <img src="images/city-lights.jpeg" alt="paris" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">City of Lights</div>
                    <div class="image-location">Paris, France</div>
                </div>
            </div>

            <div class="gallery-item" data-category="cities">
                <div class="gallery-image">
                    <img src="images/urban-jungle.jpg" alt="urban-jungle" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Urban Jungle</div>
                    <div class="image-location">New York, USA</div>
                </div>
            </div>

            <!-- Wilderness Images -->
            <div class="gallery-item" data-category="wilderness">
                <div class="gallery-image">
                    <img src="images/amazon.jpg" alt="amazon" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Ancient Forest</div>
                    <div class="image-location">Amazon, Brazil</div>
                </div>
            </div>

            <div class="gallery-item" data-category="wilderness">
                <div class="gallery-image">
                    <img src="images/sahara.jpg" alt="sahara" class="gallery-image">
                </div>
                <div class="image-overlay">
                    <div class="image-title">Desert Expedition</div>
                    <div class="image-location">Sahara, Africa</div>
                </div>
            </div>
        </div>

        <div class="upload-section">
            <h2>Share Your Adventure</h2>
            <p>Have amazing travel photos? Share them with our community!</p>
            <button class="upload-btn" onclick="uploadPhoto()">
                📸 Upload Your Photos
            </button>
        </div>
    </div>

    <!-- Go to Top Button -->
    <button class="go-to-top" onclick="scrollToTop()">↑</button>

    <script>
        // Upload button functionality
        function uploadPhoto() {
            alert('📸 Photo upload feature coming soon! For now, enjoy browsing our gallery.');
        }

        // Go to Top Functionality
        const goToTopBtn = document.querySelector('.go-to-top');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                goToTopBtn.style.display = 'block';
            } else {
                goToTopBtn.style.display = 'none';
            }
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>

</body>
</html>