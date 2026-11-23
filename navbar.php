<?php require_once 'init.php'; ?>
<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TripWise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .nav-links a.active { 
            color: #D4A574 !important; 
            font-weight: bold; 
            background: rgba(255,255,255,0.15); 
            border-bottom: 2px solid #D4A574; 
        }
        
        .user-dropdown { position: relative; margin-left: 1rem; }
        .user-trigger {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            color: rgba(255,255,255,0.97);
            font-weight: 600;
            font-size: 1.05rem;
            padding: 0.6rem 1.2rem;
            border: 1.5px solid rgba(95,141,122,0.3);
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .user-trigger:hover { background: rgba(255,255,255,0.4); border-color: #5F8D7A; transform: translateY(-2px); }
        .dropdown-menu {
            position: absolute;
            top: 110%; right: 0;
            min-width: 200px;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(16px);
            border-radius: 16px;
            border: 1px solid rgba(95,141,122,0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s ease; z-index: 999; overflow: hidden;
        }
        .dropdown-menu.active { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu a { display: block; padding: 0.9rem 1.2rem; color: #2d3748; text-decoration: none; transition: 0.3s; }
        .dropdown-menu a:hover { background: rgba(95,141,122,0.1); color: #5F8D7A; }
        .dropdown-menu hr { margin: 0.5rem 0; border: none; border-top: 1px solid #e2e8f0; }
        .logout-item { color: #E53E3E !important; }
        .logout-item:hover { background: rgba(229,62,62,0.1) !important; }
    </style>
</head>
<body>
    <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

    <nav class="navbar">
        <div class="nav-brand"><a href="index.php">TripWise</a></div>
        <ul class="nav-links">
            <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="destinations.php" class="<?php echo $current_page == 'destinations.php' ? 'active' : ''; ?>">Destinations</a></li>
            <li><a href="itinerary.php" class="<?php echo $current_page == 'itinerary.php' ? 'active' : ''; ?>">Itinerary</a></li>
            <li><a href="gallery.php" class="<?php echo $current_page == 'gallery.php' ? 'active' : ''; ?>">Gallery</a></li>
            <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a></li>
            <li id="authSection"></li>
        </ul>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const authSection = document.getElementById('authSection');
            <?php if (isset($_SESSION['user_id'])): ?>
                const name = "<?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'User')[0]); ?>";
                authSection.innerHTML = `
                    <div class="user-dropdown">
                        <button class="user-trigger" onclick="toggleDropdown(event)">
                            Hi, ${name}
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="itinerary.php">My Trips</a>
                            <hr>
                            <a href="api/logout.php" class="logout-item">Logout</a>
                        </div>
                    </div>`;
            <?php else: ?>
                authSection.innerHTML = `<a href="registration.php" class="${location.pathname.includes('registration.php') ? 'active' : ''}">Login</a>`;
            <?php endif; ?>
        });

        function toggleDropdown(e) {
            e.stopPropagation();
            document.getElementById('userDropdown')?.classList.toggle('active');
        }
        document.addEventListener('click', () => document.getElementById('userDropdown')?.classList.remove('active'));
    </script>
</body>
</html>