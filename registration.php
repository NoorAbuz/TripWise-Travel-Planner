<?php require_once 'init.php'; ?>

<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // LOGIN
    if (isset($_POST['login'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: itinerary.php");
            exit;
        } else {
            $message = "Wrong email or password";
        }
    }

    // REGISTER
    if (isset($_POST['register'])) {
        $name = trim($_POST['name'] ?? '');
        $confirm = $_POST['confirm'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $message = "All fields are required";
        } elseif ($password !== $confirm) {
            $message = "Passwords do not match";
        } elseif (strlen($password) < 6) {
            $message = "Password must be at least 6 characters";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hash]);
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $name;
                header("Location: itinerary.php");
                exit;
            } catch (Exception $e) {
                $message = "Email already exists";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - TripWise</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { margin:0; font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height:100vh; }
        .auth-container { max-width: 500px; margin: 0 auto; padding: 2rem; min-height: calc(100vh - 80px); display: flex; align-items: center; justify-content: center; }
        .auth-card { background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.15); width: 100%; }
        .auth-card h1 { color: #5F8D7A; text-align: center; margin: 0 0 0.5rem 0; font-size: 2.2rem; font-weight: 700; }
        .auth-card > p { text-align: center; color: #7A9EB1; margin-bottom: 2rem; }

        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #5F8D7A; }
        .form-input { width: 100%; padding: 0.9rem; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 1rem; box-sizing: border-box; transition: border 0.3s; }
        .form-input:focus { outline: none; border-color: #5F8D7A; box-shadow: 0 0 0 3px rgba(95,141,122,0.1); }

        .submit-btn { 
            background: #D4A574; 
            color: white; 
            border: none; 
            padding: 1rem; 
            width: 100%; 
            border-radius: 25px; 
            font-weight: 600; 
            font-size: 1.1rem;
            cursor: pointer; 
            margin-top: 0.5rem;
            transition: all 0.3s;
        }
        .submit-btn:hover { background: #c09565; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(212,165,116,0.3); }

        .error { background: #fee; color: #c33; padding: 1rem; border-radius: 12px; margin: 1rem 0; text-align: center; font-weight: 500; }

        /* CREATE ACCOUNT SECTION — NOW MATCHES THEME PERFECTLY */
        .create-account-section {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 16px;
            margin-top: 2rem;
            text-align: center;
            border: 2px dashed #E2E8F0;
        }
        .create-account-section h3 {
            color: #5F8D7A;
            margin: 0 0 1rem 0;
            font-size: 1.3rem;
        }
        .create-account-section p {
            color: #7A9EB1;
            margin-bottom: 1.5rem;
        }
        .btn-create-account {
            background: #5F8D7A;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-create-account:hover {
            background: #4a7a65;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(95,141,122,0.3);
        }

        /* MODAL */
        .modal { 
            display: none; 
            position: fixed; inset: 0; 
            background: rgba(0,0,0,0.6); 
            align-items: center; 
            justify-content: center; 
            z-index: 1000;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .modal h2 { color: #5F8D7A; text-align: center; margin-bottom: 1.5rem; }
        .modal-buttons { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-save { flex: 1; background: #5F8D7A; color: white; border: none; padding: 1rem; border-radius: 12px; font-weight: 600; cursor: pointer; }
        .btn-cancel { flex: 1; background: #E2E8F0; color: #2D3748; border: none; padding: 1rem; border-radius: 12px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="auth-container">
        <div class="auth-card">
            <h1>Welcome Back</h1>
            <p>Sign in to continue your journey</p>

            <?php if($message): ?>
                <div class="error"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <!-- LOGIN FORM -->
            <form method="POST">
                <input type="hidden" name="login" value="1">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <button type="submit" class="submit-btn">SIGN IN</button>
            </form>

            <!-- CREATE ACCOUNT SECTION - NOW BEAUTIFUL -->
            <div class="create-account-section">
                <h3>Don't have an account yet?</h3>
                <p>Join thousands of travelers planning their dream trips</p>
                <button type="button" class="btn-create-account" onclick="document.getElementById('registerModal').classList.add('active')">
                    CREATE NEW ACCOUNT
                </button>
            </div>
        </div>
    </div>

    <!-- REGISTER MODAL -->
    <div class="modal" id="registerModal">
        <div class="modal-content">
            <h2>Create Your Account</h2>
            <form method="POST">
                <input type="hidden" name="register" value="1">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-input" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-input" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm" class="form-input" required>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-save">CREATE ACCOUNT</button>
                    <button type="button" class="btn-cancel" onclick="document.getElementById('registerModal').classList.remove('active')">CANCEL</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Close modal on outside click or Escape
        document.getElementById('registerModal').addEventListener('click', e => {
            if (e.target === e.currentTarget) e.currentTarget.classList.remove('active');
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.getElementById('registerModal').classList.remove('active');
        });

        document.addEventListener('DOMContentLoaded', function() {
            alert('You are logged out.');
        });
    </script>
</body>
</html>