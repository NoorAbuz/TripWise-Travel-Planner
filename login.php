<?php include 'navbar.php'; ?>
<div class="page-hero-title">
    <h1>Welcome Back</h1>
    <p>Login to continue your journey</p>
</div>

<div class="container" style="max-width: 500px; margin: 3rem auto;">
    <form method="POST" style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-input" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-input" required></div>
        <button type="submit" class="btn-primary" style="width:100%; margin-top:1rem;">Login</button>
        <p style="text-align:center; margin-top:1rem;">No account? <a href="registration.php">Register here</a></p>
    </form>
</div>

<?php
session_start();
include 'db.php';
if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        echo "<script>alert('Welcome back, ".$user['name']."'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Wrong email or password');</script>";
    }
}
?>