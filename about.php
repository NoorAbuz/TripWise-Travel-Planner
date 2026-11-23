<?php require_once 'init.php'; ?>
<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - TripWise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0);
            backdrop-filter: blur(2px);
            min-height: calc(100vh - 80px);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #5F8D7A, #7A9EB1);
            color: white;
            padding: 4rem 2rem;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 4rem;
        }

        .hero-section h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .hero-section p {
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Mission Section */
        .mission-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 4rem;
            align-items: center;
        }

        .mission-content h2 {
            color: #5F8D7A;
            margin-bottom: 1.5rem;
        }

        .mission-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            border-radius: 12px;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: #F8F9FA;
            border-radius: 10px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #5F8D7A;
            display: block;
        }

        .stat-label {
            color: #7A9EB1;
            font-size: 0.9rem;
        }

        /* Team Section */
        .team-section {
            margin-bottom: 4rem;
        }

        .team-section h2 {
            text-align: center;
            color: #5F8D7A;
            margin-bottom: 3rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .team-member {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
        }

        .member-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5F8D7A, #7A9EB1);
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .member-name {
            color: #5F8D7A;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .member-role {
            color: #D4A574;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .member-bio {
            color: #2D3748;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Values Section */
        .values-section {
            background: #F8F9FA;
            padding: 4rem 2rem;
            border-radius: 15px;
            margin-bottom: 4rem;
        }

        .values-section h2 {
            text-align: center;
            color: #5F8D7A;
            margin-bottom: 3rem;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .value-item {
            text-align: center;
            padding: 2rem 1rem;
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .value-title {
            color: #5F8D7A;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .value-description {
            color: #2D3748;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            text-align: center;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #D4A574, #c09565);
            color: white;
            border-radius: 15px;
        }

        .cta-section h2 {
            margin-bottom: 1rem;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .cta-btn {
            background: white;
            color: #5F8D7A;
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .mission-section {
                grid-template-columns: 1fr;
            }
            
            .mission-stats {
                grid-template-columns: 1fr;
            }
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

    <div class="about-container">
        <!-- Header -->
        <div class="page-header">
            <h1>About TripWise</h1>
            <p>Creating unforgettable travel experiences since 2024</p>
        </div>

        <!-- Hero Section -->
        <section class="hero-section">
            <h2>Our Story</h2>
            <p>TripWise was born from a simple idea: travel should be accessible, memorable, and transformative. We believe every journey tells a story, and we're here to help you write yours.</p>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <div class="mission-content">
                <h2>Our Mission</h2>
                <p>To inspire and enable people to explore the world confidently, creating meaningful connections with different cultures and environments while promoting sustainable travel practices.</p>
                
                <div class="mission-stats">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Destinations</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10K+</span>
                        <span class="stat-label">Happy Travelers</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Continents</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Satisfaction Rate</span>
                    </div>
                </div>
            </div>
            
            <div class="mission-visual">
                <div style="background: linear-gradient(135deg, #7A9EB1, #5F8D7A); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;" class="gallery-image">
                    <img src="images/map.jpg" alt="🌍" class="gallery-image">
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <h2>Meet Our Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">👨‍💼</div>
                    <div class="member-name">Alex Chen</div>
                    <div class="member-role">Founder & CEO</div>
                    <p class="member-bio">Former travel journalist with 15+ years exploring remote destinations worldwide.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">👩‍💻</div>
                    <div class="member-name">Sarah Johnson</div>
                    <div class="member-role">Head of Operations</div>
                    <p class="member-bio">Expert in creating seamless travel experiences across 50+ countries.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">👨‍🎨</div>
                    <div class="member-name">Marcus Rivera</div>
                    <div class="member-role">Travel Designer</div>
                    <p class="member-bio">Specializes in crafting unique itineraries for adventurous souls.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">👩‍💼</div>
                    <div class="member-name">Elena Petrov</div>
                    <div class="member-role">Customer Experience</div>
                    <p class="member-bio">Ensures every traveler receives personalized attention and support.</p>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="values-section">
            <h2>Our Values</h2>
            <div class="values-grid">                
                <div class="value-item">
                    <div class="value-icon">🤝</div>
                    <div class="value-title">Authentic Experiences</div>
                    <p class="value-description">We believe in meaningful connections with local cultures and environments.</p>
                </div>
                
                <div class="value-item">
                    <div class="value-icon">🛡️</div>
                    <div class="value-title">Safety First</div>
                    <p class="value-description">Your well-being is our top priority in every adventure we plan.</p>
                </div>
                
                <div class="value-item">
                    <div class="value-icon">💫</div>
                    <div class="value-title">Excellence</div>
                    <p class="value-description">We strive for perfection in every detail of your travel experience.</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <h2>Ready to Start Your Adventure?</h2>
            <p>Join thousands of travelers who have discovered the world with TripWise</p>
            <div class="cta-buttons">
                <a href="destinations.php" class="cta-btn">Explore Destinations</a>
                <a href="registration.php" class="cta-btn">Create Account</a>
            </div>
        </section>
    </div>

    <!-- Go to Top Button -->
    <button class="go-to-top" onclick="scrollToTop()">↑</button>

    <script>
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

        // Team member click effect
        document.querySelectorAll('.team-member').forEach(member => {
            member.addEventListener('click', function() {
                const name = this.querySelector('.member-name').textContent;
                const role = this.querySelector('.member-role').textContent;
                alert(`👋 Meet ${name}\n${role}\n\nGet in touch with our team for personalized travel planning!`);
            });
        });
    </script>
</body>
</html>