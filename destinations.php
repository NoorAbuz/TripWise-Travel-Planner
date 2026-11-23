<?php require_once 'init.php'; ?>
<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - TripWise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .destinations-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0);
            backdrop-filter: blur(2px);
            min-height: calc(100vh - 80px);
        }

        .destination-card {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #5F8D7A;
            transition: all 0.3s ease;
        }

        .destination-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .destination-title {
            color: #5F8D7A;
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .destination-details {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #7A9EB1;
            font-weight: 500;
        }

        .detail-value {
            color: #2D3748;
            font-weight: 600;
        }

        .destination-description {
            color: #2D3748;
            line-height: 1.6;
            padding-top: 1rem;
            border-top: 1px solid #E2E8F0;
        }

        /* Custom Destination Form */
        .custom-form-card {
            background: linear-gradient(135deg, #5F8D7A, #7A9EB1);
            color: white;
            border-left: 5px solid #D4A574;
        }

        .custom-form-card .destination-title {
            color: white;
            text-align: center;
        }

        .custom-form-card .form-input {
            background: rgba(255,255,255,0.9);
        }

        .custom-form-card .form-input:focus {
            background: white;
            box-shadow: 0 0 0 2px #D4A574;
        }

        .book-btn {
            background: #5F8D7A;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .book-btn:hover {
            background: #4a7a65;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .destination-card {
                padding: 1.5rem; /* Reduce padding on mobile */
                margin-bottom: 1.5rem;
            }
            
            .destination-title {
                font-size: 1.3rem; /* Smaller title on mobile */
            }
            
            .detail-row {
                flex-direction: column; /* Stack details vertically */
                gap: 0.5rem;
            }
            
            .book-btn {
                width: 100%; /* Full width button on mobile */
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="destinations-container">
        <div class="page-header">
            <h1>Choose Your Route</h1>
            <p>Find your perfect adventure from our curated selection</p>
        </div>

        <div class="destination-card">
            <h3 class="destination-title">JEBEL FIHRAYN - EDGE OF THE WORLD</h3>
            <div class="destination-details">
                <div class="detail-row">
                    <span class="detail-label">Best Time to Visit:</span>
                    <span class="detail-value">Oct-Apr</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Travel Time(from city centre):</span>
                    <span class="detail-value">2 hours</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Entry Fee:</span>
                    <span class="detail-value">Free</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Highlight Activity:</span>
                    <span class="detail-value">Sunset from the cliff edge, photography, off-road drive</span>
                </div>
            </div>
            <p class="destination-description">
                Dramatic cliffs rising 300 m from the desert floor offer one of the most breathtaking sunsets in the Kingdom. A short walk from the parking area leads to endless views over the untouched Arabian plateau.
            </p>
            <button class="book-btn" onclick="bookTrip('Jebel Fihrayn - Edge of the World', 'Riyadh Region')">BOOK NOW</button>        
        </div>

        <div class="destination-card">
            <h3 class="destination-title">Jeddah Waterfront</h3>
            <div class="destination-details">
                <div class="detail-row">
                    <span class="detail-label">Best Time to Visit:</span>
                    <span class="detail-value">Year-round</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Travel Time(from city centre):</span>
                    <span class="detail-value">30 minutes</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Entry Fee:</span>
                    <span class="detail-value">Free</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Highlight Activity:</span>
                    <span class="detail-value">Floating Mosque, King Fahd Fountain, street food</span>
                </div>
            </div>
            <p class="destination-description">
                30 km of sparkling Red Sea waterfront lined with sculptures, mosques, parks and cafés – the heart of modern Jeddah. Perfect for evening strolls, cycling, or simply watching the city lights dance on the water.
            </p>
            <button class="book-btn" onclick="bookTrip('Jeddah Waterfront', 'Jeddah')">BOOK NOW</button>        
        </div>

        <div class="destination-card">
            <h3 class="destination-title">Al Soudah Park</h3>
            <div class="destination-details">
                <div class="detail-row">
                    <span class="detail-label">Best Time to Visit:</span>
                    <span class="detail-value">Jun-Sep</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Travel Time(from city centre):</span>
                    <span class="detail-value">45 minutes</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Entry Fee:</span>
                    <span class="detail-value">$10-15</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Highlight Activity:</span>
                    <span class="detail-value">Cable car ride, mountain trails, local honey & roses</span>
                </div>
            </div>
            <p class="destination-description">
                Saudi Arabia’s highest peak area wrapped in juniper forests, cool mist and panoramic cable-car views. Lush green mountains feel like Switzerland, just 30 minutes from Abha city.
            </p>
            <button class="book-btn" onclick="bookTrip('Al Soudah Park', 'Abha Region')">BOOK NOW</button>        
        </div>

        <!-- Custom Destination Form -->
        <div class="destination-card custom-form-card">
            <h3 class="destination-title">CREATE CUSTOM DESTINATION</h3>
            <form id="customDestinationForm">
                <div class="form-group">
                    <label for="destinationName">Destination Name</label>
                    <input type="text" id="destinationName" class="form-input" placeholder="Enter your dream destination..." required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="duration">Duration (days)</label>
                        <input type="number" id="duration" class="form-input" placeholder="e.g., 7" min="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" class="form-input" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="distance">Route Distance (km)</label>
                    <input type="number" id="distance" class="form-input" placeholder="e.g., 50" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Additional Notes</label>
                    <textarea id="description" class="form-input" placeholder="Any special requirements or details..." rows="3"></textarea>
                </div>
                
                <button type="submit" class="submit-btn">CREATE MY TRIP</button>
            </form>
        </div>
    </div>

    <!-- Go to Top Button -->
    <button class="go-to-top" onclick="scrollToTop()">↑</button>

    <script>
        function bookTrip(tripName, region) {
            // Calculate dates (default: 7-day trip starting today)
            const startDate = new Date().toISOString().split('T')[0];
            const endDate = new Date();
            endDate.setDate(endDate.getDate() + 7);
            const endDateStr = endDate.toISOString().split('T')[0];

            fetch('api/save_trip.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    title: tripName, 
                    destination: region || tripName,
                    startDate: startDate,
                    endDate: endDateStr
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert(`Booked: ${tripName}!\nTaking you to your itinerary...`);
                    window.location.href = 'itinerary.php';
                } else {
                    alert('Error creating trip: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to book trip. Please try again.');
            });
        }

        document.getElementById('customDestinationForm').onsubmit = function(e) {
            e.preventDefault();
            const name = document.getElementById('destinationName').value.trim();
            const duration = document.getElementById('duration').value || 7;
            const startDate = document.getElementById('startDate').value;
            
            if (!name) return alert('Enter destination name');

            // Calculate end date based on duration
            const endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + parseInt(duration));
            const endDateStr = endDate.toISOString().split('T')[0];

            fetch('api/save_trip.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    title: name, 
                    destination: name,
                    startDate: startDate,
                    endDate: endDateStr
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) { 
                    alert(`Custom trip "${name}" created!`);
                    this.reset();
                    window.location.href = 'itinerary.php';
                } else {
                    alert('Error creating trip: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to create trip. Please try again.');
            });
        };

        const goToTopBtn = document.querySelector('.go-to-top');
        window.addEventListener('scroll', () => goToTopBtn.style.display = window.pageYOffset > 300 ? 'block' : 'none');
        function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('startDate').value = new Date().toISOString().split('T')[0];
        });
    </script>
</body>
</html>