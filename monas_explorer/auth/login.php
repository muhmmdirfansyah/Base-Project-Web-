<?php
require_once '../config/database.php';
$page_title = 'Login';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        $redirect = $_SESSION['redirect_url'] ?? APP_URL . '/index.php';
        unset($_SESSION['redirect_url']);
        
        redirect($redirect);
    } else {
        $error = "Email atau password salah";
    }
}
?>

<div class="auth-container">
    <h1>Login</h1>
    
    <?php if(isset($error)): ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Login</button>
    </form>
    
    <p class="auth-link">Belum punya akun? <a href="register.php">Daftar disini</a></p>
</div>

<?php include '../includes/footer.php'; ?>