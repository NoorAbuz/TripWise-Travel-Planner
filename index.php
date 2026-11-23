<?php require_once 'init.php'; ?>
<!DOCTYPE html> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripWise - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.png" type="image/x-icon">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Plan Your Perfect Trip</h1>
            <p>Discover amazing destinations around the world and create unforgettable travel experiences</p>
            <a href="destinations.php" class="cta-button">Explore Destinations</a>
        </div>
    </section>

    <section class="featured-destinations">
        <div class="container">
            <h2>Popular Destinations</h2>
            <div class="destinations-grid">
                <div class="destination-card">
                    <div class="destination-image">
                        <div class="image-placeholder">
                            <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=400" alt="Paris">
                        </div>
                    </div>
                    <div class="destination-info">
                        <h3>Paris, France</h3>
                        <p class="country">France</p>
                        <p class="description">The city of lights and love, known for its art, fashion, and culture.</p>
                        <div class="destination-meta">
                            <a href="itinerary.php?destination=paris" class="btn-plan-trip">Plan Trip</a>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-image">
                        <div class="image-placeholder">
                            <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=400" atl="Japan">
                        </div>
                    </div>
                    <div class="destination-info">
                        <h3>Tokyo, Japan</h3>
                        <p class="country">Japan</p>
                        <p class="description">Modern technology meets traditional culture in this vibrant metropolis.</p>
                        <div class="destination-meta">
                            <a href="itinerary.php?destination=tokyo" class="btn-plan-trip">Plan Trip</a>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-image">
                        <div class="image-placeholder">
                            <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=400" alt="Indonesia">
                        </div>
                    </div>
                    <div class="destination-info">
                        <h3>Bali, Indonesia</h3>
                        <p class="country">Indonesia</p>
                        <p class="description">Tropical paradise with beautiful beaches and lush rice terraces.</p>
                        <div class="destination-meta">
                            <a href="itinerary.php?destination=bali" class="btn-plan-trip">Plan Trip</a>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-image">
                        <div class="image-placeholder">
                            <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=400" atl="New York">
                        </div>
                    </div>
                    <div class="destination-info">
                        <h3>New York, USA</h3>
                        <p class="country">USA</p>
                        <p class="description">The city that never sleeps with Broadway, Central Park, and museums.</p>
                        <div class="destination-meta">
                            <a href="itinerary.php?destination=newyork" class="btn-plan-trip">Plan Trip</a>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-image">
                        <div class="image-placeholder">
                            <img src="https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?w=400&fit=crop" alt="Italy">
                        </div>
                    </div>
                    <div class="destination-info">
                        <h3>Rome, Italy</h3>
                        <p class="country">Italy</p>
                        <p class="description">The Eternal City with ancient history and incredible architecture.</p>
                        <div class="destination-meta">
                            <a href="itinerary.php?destination=rome" class="btn-plan-trip">Plan Trip</a>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-image">
                        <div class="image-placeholder">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400" alt="Switzerland">
                        </div>
                    </div>
                    <div class="destination-info">
                        <h3>Swiss Alps, Switzerland</h3>
                        <p class="country">Switzerland</p>
                        <p class="description">Breathtaking mountain scenery and charming alpine villages.</p>
                        <div class="destination-meta">
                            <a href="itinerary.php?destination=swissalps" class="btn-plan-trip">Plan Trip</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <h2>Why Choose TripWise?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🗓️</div>
                    <h3>Easy Planning</h3>
                    <p>Create detailed itineraries with our intuitive drag-and-drop builder</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Budget Management</h3>
                    <p>Track your expenses and stay within your travel budget</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌎</div>
                    <h3>Global Destinations</h3>
                    <p>Discover amazing places from around the world</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Share with Friends</h3>
                    <p>Collaborate on trip plans with your travel companions</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.btn-plan-trip').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const destination = this.getAttribute('href').split('=')[1];
                localStorage.setItem('selectedDestination', destination);
                window.location.href = 'itinerary.php';
            });
        });
    </script>

<button class="go-to-top" onclick="scrollToTop()">↑</button>

<script>
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