<?php 
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: registration.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Itineraries - TripWise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .itinerary-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            backdrop-filter: blur(2px);
            min-height: calc(100vh - 80px);
        }

        /* Dashboard View */
        .dashboard-view {
            display: block;
        }

        .trips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .trip-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #5F8D7A;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .trip-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .trip-card h3 {
            color: #5F8D7A;
            margin-bottom: 0.5rem;
        }

        .trip-destination {
            color: #7A9EB1;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .trip-dates {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .trip-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #7A9EB1;
        }

        .btn-new-trip {
            background: #5F8D7A;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 1rem 0;
        }

        .btn-new-trip:hover {
            background: #4a7a65;
            transform: translateY(-2px);
        }

        /* Trip Detail View */
        .trip-detail-view {
            display: none;
        }

        .trip-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #E2E8F0;
        }

        .trip-info h2 {
            color: #5F8D7A;
            margin-bottom: 0.5rem;
        }

        .trip-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-back {
            background: #7A9EB1;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            cursor: pointer;
        }

        .btn-delete {
            background: #E53E3E;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            cursor: pointer;
        }

        .activities-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .activity-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .activity-card h3 {
            color: #5F8D7A;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #D4A574;
            padding-bottom: 0.5rem;
        }

        .upcoming-activity {
            background: linear-gradient(135deg, #5F8D7A, #7A9EB1);
            color: white;
        }

        .upcoming-activity h3 {
            color: white;
            border-bottom-color: #D4A574;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: #F8F9FA;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            border-left: 4px solid #5F8D7A;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            transform: translateX(5px);
        }

        .activity-time {
            font-weight: 600;
            color: #5F8D7A;
            min-width: 120px;
        }

        .activity-details h4 {
            margin: 0 0 0.25rem 0;
            color: #2D3748;
        }

        .activity-details p {
            margin: 0;
            color: #7A9EB1;
            font-size: 0.9rem;
        }

        .activity-cost {
            background: #D4A574;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-right: 1rem;
        }

        .btn-remove-activity {
            background: #E53E3E;
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-remove-activity:hover {
            background: #c53030;
            transform: scale(1.1);
        }

        .btn-add-activity {
            background: #5F8D7A;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-add-activity:hover {
            background: #4a7a65;
            transform: translateY(-2px);
        }

        .next-activity {
            background: rgba(255,255,255,0.1);
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .budget-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .budget-input-group {
            display: flex;
            flex-direction: column;
        }

        .budget-input {
            padding: 0.75rem;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .budget-breakdown {
            background: #F8F9FA;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .budget-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #E2E8F0;
        }

        .budget-item.total {
            font-weight: bold;
            border-top: 2px solid #5F8D7A;
            margin-top: 0.5rem;
            padding-top: 1rem;
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #7A9EB1;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-save {
            background: #5F8D7A;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            flex: 1;
        }

        .btn-cancel {
            background: #E2E8F0;
            color: #2D3748;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            flex: 1;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #5F8D7A;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #5F8D7A;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
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

        @media (min-width: 1024px) {
            .activities-section {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="itinerary-container">
        <div class="page-header">
            <h1>My Travel Itineraries</h1>
            <p>Plan and manage all your trips in one place</p>
        </div>
        <!-- Dashboard View -->
        <div class="dashboard-view" id="dashboardView">
            <h2>Your Trips</h2>
            <p>Select a trip to view details or create a new one</p>
            
            <button class="btn-new-trip" onclick="showCreateTripModal()">+ Create New Trip</button>
            
            <div class="trips-grid" id="tripsGrid">
                <div class="empty-state" id="noTripsMessage">
                    <p>No trips planned yet</p>
                    <p>Create your first trip to get started!</p>
                </div>
            </div>
        </div>

        <!-- Trip Detail View -->
        <div class="trip-detail-view" id="tripDetailView">
            <div class="trip-header">
                <div class="trip-info">
                    <h2 id="currentTripTitle">Trip Title</h2>
                    <p id="currentTripDestination">Destination</p>
                    <p id="currentTripDates" class="trip-dates">Dates</p>
                </div>
                <div class="trip-actions">
                    <button class="btn-back" onclick="showDashboard()">← Back to All Trips</button>
                    <button class="btn-delete" onclick="deleteCurrentTrip()">Delete Trip</button>
                </div>
            </div>

            <!-- Activities Section -->
            <div class="activities-section">
                <!-- All Activities -->
                <div class="activity-card">
                    <h3>Today's Activities</h3>
                    <div class="activities-list" id="activitiesList">
                        <div class="empty-state" id="emptyActivities">
                            <p>No activities planned yet</p>
                            <p>Add your first activity to get started</p>
                        </div>
                    </div>
                    <button class="btn-add-activity" onclick="showAddActivityModal()">+ Add Activity</button>
                </div>

                <!-- Upcoming Activity -->
                <div class="activity-card upcoming-activity">
                    <h3>Next Activity</h3>
                    <div id="upcomingActivityContent">
                        <div class="empty-state" id="noUpcomingActivity">
                            <p>No upcoming activities</p>
                            <p>Add activities to see what's next</p>
                        </div>
                        <div class="next-activity" id="nextActivity" style="display: none;">
                            <div class="next-activity-time" id="nextActivityTime">09:00 AM</div>
                            <div class="next-activity-title" id="nextActivityTitle">Visit Eiffel Tower</div>
                            <div class="countdown" id="activityCountdown">Starts soon</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Section -->
            <div class="activity-card">
                <h3>Budget Summary</h3>
                <div class="budget-inputs">
                    <div class="budget-input-group">
                        <label for="activities-budget">Activities Budget ($)</label>
                        <input type="number" id="activities-budget" class="budget-input" placeholder="0" min="0" value="0">
                    </div>
                    <div class="budget-input-group">
                        <label for="accommodation-budget">Accommodation ($)</label>
                        <input type="number" id="accommodation-budget" class="budget-input" placeholder="0" min="0" value="0">
                    </div>
                    <div class="budget-input-group">
                        <label for="food-budget">Food Budget ($)</label>
                        <input type="number" id="food-budget" class="budget-input" placeholder="0" min="0" value="0">
                    </div>
                    <div class="budget-input-group">
                        <label for="transportation-budget">Transportation ($)</label>
                        <input type="number" id="transportation-budget" class="budget-input" placeholder="0" min="0" value="0">
                    </div>
                </div>
                
                <div class="budget-breakdown">
                    <div class="budget-item">
                        <span>Activities Budget:</span>
                        <span id="activities-budget-display">$0</span>
                    </div>
                    <div class="budget-item">
                        <span>Activities Spent:</span>
                        <span id="activities-spent">$0</span>
                    </div>
                    <div class="budget-item">
                        <span>Accommodation:</span>
                        <span id="accommodation-cost">$0</span>
                    </div>
                    <div class="budget-item">
                        <span>Food:</span>
                        <span id="food-cost">$0</span>
                    </div>
                    <div class="budget-item">
                        <span>Transportation:</span>
                        <span id="transportation-cost">$0</span>
                    </div>
                    <div class="budget-item total">
                        <span>Total Budget:</span>
                        <span id="total-budget">$0</span>
                    </div>
                    <div class="budget-item" style="color: #27ae60; font-weight: 600;">
                        <span>Remaining:</span>
                        <span id="remaining-budget">$0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Trip Modal -->
    <div class="modal" id="createTripModal">
        <div class="modal-content">
            <h2>Create New Trip</h2>
            <form id="createTripForm">
                <div class="form-group">
                    <label for="trip-title">Trip Title *</label>
                    <input type="text" id="trip-title" class="form-input" placeholder="e.g., Summer Europe Adventure" required>
                </div>
                <div class="form-group">
                    <label for="destination">Destination *</label>
                    <input type="text" id="destination" class="form-input" placeholder="Enter destination..." required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="start-date">Start Date *</label>
                        <input type="date" id="start-date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End Date *</label>
                        <input type="date" id="end-date" class="form-input" required>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Create Trip</button>
                    <button type="button" class="btn-cancel" onclick="hideCreateTripModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Activity Modal -->
    <div class="modal" id="addActivityModal">
        <div class="modal-content">
            <h2>Add New Activity</h2>
            <form id="addActivityForm">
                <div class="form-group">
                    <label for="activity-title">Activity Title *</label>
                    <input type="text" id="activity-title" class="form-input" placeholder="e.g., Visit Eiffel Tower" required>
                </div>
                <div class="form-group">
                    <label for="activity-description">Description</label>
                    <textarea id="activity-description" class="form-input" placeholder="Activity details..." rows="3"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="activity-date">Date *</label>
                        <input type="date" id="activity-date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="activity-time">Time *</label>
                        <input type="time" id="activity-time" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="activity-cost">Estimated Cost ($)</label>
                    <input type="number" id="activity-cost" class="form-input" placeholder="0" min="0" value="0">
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Add Activity</button>
                    <button type="button" class="btn-cancel" onclick="hideAddActivityModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Go to Top Button -->
    <button class="go-to-top" onclick="scrollToTop()">↑</button>

    <script>
    // Trip Management System
    let trips = [];
    let currentTripId = null;
    let currentTripData = null;
    let editingActivityIndex = undefined;

    // Initialize application
    document.addEventListener('DOMContentLoaded', function() {
        initApp();
    });

    function initApp() {
        loadTrips();
        setupEventListeners();
        setDefaultDates();
    }

    function loadTrips() {
        fetch('api/get_trips.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Loaded trips:', data);
                trips = data.trips || [];
                renderDashboard();
            })
            .catch(error => {
                console.error('Error loading trips:', error);
                showError('Failed to load trips. Please check your connection.');
                trips = [];
                // Don't call renderDashboard() here if there's an error
            });
    }

    function setupEventListeners() {
        // Form submissions
        document.getElementById('createTripForm').addEventListener('submit', function(e) {
            e.preventDefault();
            createNewTrip();
        });

        document.getElementById('addActivityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (window.editingActivityIndex !== undefined) {
                updateActivity(window.editingActivityIndex);
            } else {
                addNewActivity();
            }
        });

       // Budget tracking with auto-save
        document.getElementById('activities-budget').addEventListener('input', function() {
            updateBudget();
            setTimeout(saveBudgets, 1000); // Save after 1 second delay
        });
        document.getElementById('accommodation-budget').addEventListener('input', function() {
            updateBudget();
            setTimeout(saveBudgets, 1000);
        });
        document.getElementById('food-budget').addEventListener('input', function() {
            updateBudget();
            setTimeout(saveBudgets, 1000);
        });
        document.getElementById('transportation-budget').addEventListener('input', function() {
            updateBudget();
            setTimeout(saveBudgets, 1000);
        });

        // Modal close handlers
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
    }

    function renderDashboard() {
        const tripsGrid = document.getElementById('tripsGrid');
        const noTripsMessage = document.getElementById('noTripsMessage');

        // Check if elements exist before using them
        if (!tripsGrid || !noTripsMessage) {
            console.error('Dashboard elements not found');
            return;
        }

        if (trips.length === 0) {
            noTripsMessage.style.display = 'block';
            tripsGrid.innerHTML = '';
            return;
        }

        noTripsMessage.style.display = 'none';
        tripsGrid.innerHTML = '';

        trips.forEach(trip => {
            const activityCount = trip.activities ? trip.activities.length : 0;
            const totalBudget = calculateTotalBudget(trip);

            const tripCard = document.createElement('div');
            tripCard.className = 'trip-card';
            tripCard.innerHTML = `
                <h3>${escapeHtml(trip.title)}</h3>
                <div class="trip-destination">${escapeHtml(trip.destination)}</div>
                <div class="trip-dates">${formatDate(trip.start_date)} - ${formatDate(trip.end_date)}</div>
                <div class="trip-stats">
                    <span>${activityCount} activities</span>
                    <span>$${totalBudget} budget</span>
                </div>
            `;
            tripCard.onclick = () => showTripDetail(trip.id);
            tripsGrid.appendChild(tripCard);
        });
    }

    function showTripDetail(tripId) {
        const trip = trips.find(t => t.id === tripId);
        if (!trip) {
            console.error('Trip not found:', tripId);
            showError('Trip not found');
            return;
        }

        currentTripId = tripId;
        currentTripData = trip;
        
        // Update trip header
        document.getElementById('currentTripTitle').textContent = trip.title;
        document.getElementById('currentTripDestination').textContent = trip.destination;
        document.getElementById('currentTripDates').textContent = `${formatDate(trip.start_date)} - ${formatDate(trip.end_date)}`;
        
        // Initialize trip data
        if (!trip.activities) trip.activities = [];
        if (!trip.budgets) {
            trip.budgets = {
                activities: 0,
                accommodation: 0,
                food: 0,
                transportation: 0
            };
        }
        
        // Load data
        loadBudgets(trip);
        renderActivities(trip);
        updateBudget();
        updateNextActivity(trip);
        
        // Show detail view
        document.getElementById('dashboardView').style.display = 'none';
        document.getElementById('tripDetailView').style.display = 'block';
    }

    function loadBudgets(trip) {
        document.getElementById('activities-budget').value = trip.budgets.activities || 0;
        document.getElementById('accommodation-budget').value = trip.budgets.accommodation || 0;
        document.getElementById('food-budget').value = trip.budgets.food || 0;
        document.getElementById('transportation-budget').value = trip.budgets.transportation || 0;
    }

    function renderActivities(trip) {
        const activitiesList = document.getElementById('activitiesList');
        const emptyActivities = document.getElementById('emptyActivities');

        // Check if elements exist before using them
        if (!activitiesList || !emptyActivities) {
            console.error('Activity elements not found');
            return;
        }

        if (!trip.activities || trip.activities.length === 0) {
            emptyActivities.style.display = 'block';
            activitiesList.innerHTML = '';
            return;
        }

        emptyActivities.style.display = 'none';
        activitiesList.innerHTML = '';

        // Sort activities by date and time
        const sortedActivities = [...trip.activities].sort((a, b) => {
            try {
                const dateA = new Date(a.activity_date + ' ' + a.activity_time);
                const dateB = new Date(b.activity_date + ' ' + b.activity_time);
                return dateA - dateB;
            } catch (e) {
                return 0;
            }
        });

        sortedActivities.forEach((activity, index) => {
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item';
            activityItem.innerHTML = `
                <div class="activity-time">${formatTime(activity.activity_time)}</div>
                <div class="activity-details">
                    <h4>${escapeHtml(activity.title)}</h4>
                    <p>${escapeHtml(activity.description || 'No description')}</p>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span class="activity-cost">$${activity.cost || 0}</span>
                    <button class="btn-edit-activity" onclick="editActivity(${index})" style="background: #7A9EB1; color: white; border: none; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;">✎</button>
                    <button class="btn-remove-activity" onclick="removeActivity(${index})">×</button>
                </div>
            `;
            activitiesList.appendChild(activityItem);
        });
    }

    function editActivity(activityIndex) {
        if (!currentTripData || !currentTripData.activities) return;
        
        const activity = currentTripData.activities[activityIndex];
        
        // Fill the modal with existing activity data
        document.getElementById('activity-title').value = activity.title;
        document.getElementById('activity-description').value = activity.description || '';
        document.getElementById('activity-date').value = activity.activity_date;
        document.getElementById('activity-time').value = activity.activity_time;
        document.getElementById('activity-cost').value = activity.cost || 0;
        
        // Store the activity index for updating
        window.editingActivityIndex = activityIndex;
        
        // Change the modal to edit mode
        document.getElementById('addActivityModal').querySelector('h2').textContent = 'Edit Activity';
        document.getElementById('addActivityModal').querySelector('.btn-save').textContent = 'Update Activity';
        
        showAddActivityModal();
    }

    function updateActivity(activityIndex) {
        if (!currentTripId || !currentTripData) return;

        const title = document.getElementById('activity-title').value.trim();
        const description = document.getElementById('activity-description').value.trim();
        const date = document.getElementById('activity-date').value;
        const time = document.getElementById('activity-time').value;
        const cost = parseFloat(document.getElementById('activity-cost').value) || 0;

        // Validation
        if (!title || !date || !time) {
            showError('Please fill in all required fields');
            return;
        }

        // Update the activity in the array - Use the exact same structure as when loading
        const updatedActivities = [...currentTripData.activities];
        updatedActivities[activityIndex] = {
            title: title,
            description: description,
            activity_date: date,  // Make sure this matches what the API expects
            activity_time: time,  // Make sure this matches what the API expects  
            cost: cost
        };

        const updatedTrip = {
            id: currentTripId,
            activities: updatedActivities,
            budgets: currentTripData.budgets || {
                activities: 0,
                accommodation: 0,
                food: 0,
                transportation: 0
            }
        };

        console.log('Sending update:', updatedTrip);

        // Save to database
        fetch('api/save_full_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedTrip)
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error: ${response.status} - ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Update response:', data);
            if (data.success) {
                hideAddActivityModal();
                
                // Update local data
                currentTripData.activities = updatedActivities;
                
                // Refresh the view
                renderActivities(currentTripData);
                updateBudget();
                updateNextActivity(currentTripData);
                
                // Also update the trips array
                const tripIndex = trips.findIndex(t => t.id === currentTripId);
                if (tripIndex !== -1) {
                    trips[tripIndex] = {...trips[tripIndex], activities: updatedActivities};
                }
                
                // Reset edit mode
                window.editingActivityIndex = undefined;
                
                alert('Activity updated successfully!'); // Success message
            } else {
                showError(data.message || 'Error updating activity');
            }
        })
        .catch(error => {
            console.error('Error updating activity:', error);
            showError('Failed to update activity: ' + error.message);
        });
    }

    function createNewTrip() {
        const title = document.getElementById('trip-title').value.trim();
        const destination = document.getElementById('destination').value.trim();
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        // Validation
        if (!title || !destination || !startDate || !endDate) {
            showError('Please fill in all required fields');
            return;
        }

        const tripData = {
            title: title,
            destination: destination,
            startDate: startDate,
            endDate: endDate
        };

        console.log('Creating trip:', tripData);

        fetch('api/save_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(tripData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Create trip response:', data);
            if (data.success) {
                hideCreateTripModal();
                loadTrips(); // Reload trips to include the new one
                
                // Auto-show the new trip after a short delay
                setTimeout(() => {
                    if (data.trip_id) {
                        // Find the trip in the loaded trips and show it
                        const newTrip = trips.find(t => t.id === data.trip_id);
                        if (newTrip) {
                            showTripDetail(data.trip_id);
                        } else {
                            // If not found, reload and try again
                            loadTrips();
                        }
                    }
                }, 500);
            } else {
                showError(data.message || 'Error creating trip');
            }
        })
        .catch(error => {
            console.error('Error creating trip:', error);
            showError('Failed to create trip. Please check your connection.');
        });
    }

    function addNewActivity() {
        if (!currentTripId) {
            showError('Please select a trip first');
            return;
        }

        const title = document.getElementById('activity-title').value.trim();
        const description = document.getElementById('activity-description').value.trim();
        const date = document.getElementById('activity-date').value;
        const time = document.getElementById('activity-time').value;
        const cost = parseFloat(document.getElementById('activity-cost').value) || 0;

        // Validation
        if (!title || !date || !time) {
            showError('Please fill in all required fields');
            return;
        }

        // Create updated trip data with new activity - USE CORRECT FIELD NAMES
        const updatedTrip = {
            id: currentTripId,
            activities: [
                ...(currentTripData.activities || []),
                {
                    title: title,
                    description: description,
                    activity_date: date,  // Changed from 'date'
                    activity_time: time,  // Changed from 'time' 
                    cost: cost
                }
            ],
            budgets: currentTripData.budgets || {
                activities: 0,
                accommodation: 0,
                food: 0,
                transportation: 0
            }
        };

        console.log('Adding activity:', updatedTrip);

        // Save to database
        fetch('api/save_full_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedTrip)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Add activity response:', data);
            if (data.success) {
                hideAddActivityModal();
                
                // Update local data immediately without reloading
                currentTripData.activities = updatedTrip.activities;
                
                // Refresh the current view instantly
                renderActivities(currentTripData);
                updateBudget();
                updateNextActivity(currentTripData);
                
                // Also update the trips array for the dashboard
                const tripIndex = trips.findIndex(t => t.id === currentTripId);
                if (tripIndex !== -1) {
                    trips[tripIndex] = {...trips[tripIndex], activities: updatedTrip.activities};
                }
            } else {
                showError(data.message || 'Error adding activity');
            }
        })
        .catch(error => {
            console.error('Error adding activity:', error);
            showError('Failed to add activity. Please check your connection.');
        });
    }

    function removeActivity(activityIndex) {
        if (!currentTripData || !currentTripData.activities) return;

        if (confirm('Are you sure you want to remove this activity?')) {
            // Remove activity from array
            const updatedActivities = [...currentTripData.activities];
            updatedActivities.splice(activityIndex, 1);
            
            const updatedTrip = {
                id: currentTripId,
                activities: updatedActivities,
                budgets: currentTripData.budgets
            };

            console.log('Removing activity:', updatedTrip);

            // Save updated trip to database
            fetch('api/save_full_trip.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    },
                body: JSON.stringify(updatedTrip)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Remove activity response:', data);
                if (data.success) {
                    // Update local data immediately without reloading
                    currentTripData.activities = updatedActivities;
                    
                    // Refresh the current view instantly
                    renderActivities(currentTripData);
                    updateBudget();
                    updateNextActivity(currentTripData);
                    
                    // Also update the trips array for the dashboard
                    const tripIndex = trips.findIndex(t => t.id === currentTripId);
                    if (tripIndex !== -1) {
                        trips[tripIndex] = {...trips[tripIndex], activities: updatedActivities};
                    }
                } else {
                    showError(data.message || 'Error removing activity');
                }
            })
            .catch(error => {
                console.error('Error removing activity:', error);
                showError('Failed to remove activity. Please check your connection.');
            });
        }
    }

    function updateBudget() {
        if (!currentTripData) return;

        // Update budgets from inputs
        currentTripData.budgets = {
            activities: parseInt(document.getElementById('activities-budget').value) || 0,
            accommodation: parseInt(document.getElementById('accommodation-budget').value) || 0,
            food: parseInt(document.getElementById('food-budget').value) || 0,
            transportation: parseInt(document.getElementById('transportation-budget').value) || 0
        };

        // Calculate totals
        const activitiesSpent = currentTripData.activities ? 
            currentTripData.activities.reduce((sum, activity) => sum + (parseFloat(activity.cost) || 0), 0) : 0;
        
        const totalBudget = Object.values(currentTripData.budgets).reduce((sum, val) => sum + val, 0);
        const totalSpent = activitiesSpent + currentTripData.budgets.accommodation + currentTripData.budgets.food + currentTripData.budgets.transportation;
        const remaining = totalBudget - totalSpent;

        // Update display
        document.getElementById('activities-budget-display').textContent = `$${currentTripData.budgets.activities}`;
        document.getElementById('activities-spent').textContent = `$${activitiesSpent.toFixed(2)}`;
        document.getElementById('accommodation-cost').textContent = `$${currentTripData.budgets.accommodation}`;
        document.getElementById('food-cost').textContent = `$${currentTripData.budgets.food}`;
        document.getElementById('transportation-cost').textContent = `$${currentTripData.budgets.transportation}`;
        document.getElementById('total-budget').textContent = `$${totalBudget}`;
        document.getElementById('remaining-budget').textContent = `$${remaining.toFixed(2)}`;
        document.getElementById('remaining-budget').style.color = remaining >= 0 ? '#27ae60' : '#e74c3c';
    }

    function updateNextActivity(trip) {
        const noUpcomingElement = document.getElementById('noUpcomingActivity');
        const nextActivityElement = document.getElementById('nextActivity');
        
        if (!trip.activities || trip.activities.length === 0) {
            noUpcomingElement.style.display = 'block';
            nextActivityElement.style.display = 'none';
            return;
        }

        // Find next upcoming activity
        const now = new Date();
        const upcomingActivities = trip.activities
            .filter(activity => {
                try {
                    const activityDateTime = new Date(activity.activity_date + ' ' + activity.activity_time);
                    return activityDateTime > now;
                } catch (e) {
                    return false;
                }
            })
            .sort((a, b) => {
                try {
                    const dateA = new Date(a.activity_date + ' ' + a.activity_time);
                    const dateB = new Date(b.activity_date + ' ' + b.activity_time);
                    return dateA - dateB;
                } catch (e) {
                    return 0;
                }
            });

        if (upcomingActivities.length > 0) {
            const nextActivity = upcomingActivities[0];
            noUpcomingElement.style.display = 'none';
            nextActivityElement.style.display = 'block';
            
            try {
                document.getElementById('nextActivityTime').textContent = 
                    `${formatDate(nextActivity.activity_date)} at ${formatTime(nextActivity.activity_time)}`;
                document.getElementById('nextActivityTitle').textContent = nextActivity.title;
                
                // Countdown
                const activityTime = new Date(nextActivity.activity_date + ' ' + nextActivity.activity_time);
                const timeDiff = activityTime - now;
                const hoursLeft = Math.floor(timeDiff / (1000 * 60 * 60));
                
                if (hoursLeft < 1) {
                    document.getElementById('activityCountdown').textContent = 'Starting soon!';
                } else if (hoursLeft < 24) {
                    document.getElementById('activityCountdown').textContent = `In ${hoursLeft} hours`;
                } else {
                    const daysLeft = Math.floor(hoursLeft / 24);
                    document.getElementById('activityCountdown').textContent = `In ${daysLeft} days`;
                }
            } catch (e) {
                document.getElementById('activityCountdown').textContent = 'Time calculation error';
            }
        } else {
            noUpcomingElement.style.display = 'block';
            nextActivityElement.style.display = 'none';
        }
    }

    function deleteCurrentTrip() {
        if (!currentTripId) return;

        if (confirm('Are you sure you want to delete this trip? This cannot be undone.')) {
            fetch('api/delete_trip.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ trip_id: currentTripId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showDashboard();
                    loadTrips();
                } else {
                    showError(data.message || 'Error deleting trip');
                }
            })
            .catch(error => {
                console.error('Error deleting trip:', error);
                showError('Failed to delete trip. Please check your connection.');
            });
        }
    }

    function showDashboard() {
        document.getElementById('dashboardView').style.display = 'block';
        document.getElementById('tripDetailView').style.display = 'none';
        currentTripId = null;
        currentTripData = null;
    }

    function showCreateTripModal() {
        document.getElementById('createTripModal').style.display = 'flex';
    }

    function hideCreateTripModal() {
        document.getElementById('createTripModal').style.display = 'none';
        document.getElementById('createTripForm').reset();
        setDefaultDates();
    }

    function showAddActivityModal() {
        document.getElementById('addActivityModal').style.display = 'flex';
        // Set default date to today
        document.getElementById('activity-date').value = new Date().toISOString().split('T')[0];
    }

    function hideAddActivityModal() {
        document.getElementById('addActivityModal').style.display = 'none';
        document.getElementById('addActivityForm').reset();
        
        // Reset to add mode
        document.getElementById('addActivityModal').querySelector('h2').textContent = 'Add New Activity';
        document.getElementById('addActivityModal').querySelector('.btn-save').textContent = 'Add Activity';
        window.editingActivityIndex = undefined;
        
        // Set default date to today
        document.getElementById('activity-date').value = new Date().toISOString().split('T')[0];
    }

    function setDefaultDates() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start-date').value = today;
        
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 7);
        document.getElementById('end-date').value = nextWeek.toISOString().split('T')[0];
    }

    function calculateTotalBudget(trip) {
        if (!trip.budgets) return 0;
        return Object.values(trip.budgets).reduce((a, b) => a + b, 0);
    }

    function saveBudgets() {
        if (!currentTripId || !currentTripData) return;

        // Update current trip data with current budget values
        currentTripData.budgets = {
            activities: parseInt(document.getElementById('activities-budget').value) || 0,
            accommodation: parseInt(document.getElementById('accommodation-budget').value) || 0,
            food: parseInt(document.getElementById('food-budget').value) || 0,
            transportation: parseInt(document.getElementById('transportation-budget').value) || 0
        };

        // Save to database
        const saveData = {
            id: currentTripId,
            budgets: currentTripData.budgets,
            activities: currentTripData.activities || []
        };

        fetch('api/save_full_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(saveData)
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error saving budgets:', data.message);
            } else {
                // Update the trips array for the dashboard
                const tripIndex = trips.findIndex(t => t.id === currentTripId);
                if (tripIndex !== -1) {
                    trips[tripIndex] = {...trips[tripIndex], budgets: currentTripData.budgets};
                }
            }
        })
        .catch(error => {
            console.error('Error saving budgets:', error);
        });
    }

    function formatDate(dateString) {
        if (!dateString) return 'No date';
        try {
            return new Date(dateString).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        } catch (e) {
            return 'Invalid date';
        }
    }

    function formatTime(timeString) {
        if (!timeString) return 'No time';
        try {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes.padStart(2, '0')} ${ampm}`;
        } catch (e) {
            return 'Invalid time';
        }
    }

    function escapeHtml(unsafe) {
        if (unsafe === null || unsafe === undefined) return '';
        return unsafe
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function showError(message) {
        alert('Error: ' + message);
    }

    // Go to Top Functionality
    const goToTopBtn = document.querySelector('.go-to-top');
    window.addEventListener('scroll', function() {
        goToTopBtn.style.display = window.pageYOffset > 300 ? 'block' : 'none';
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
</body>
</html>