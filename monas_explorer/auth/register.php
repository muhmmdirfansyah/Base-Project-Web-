<?php
require_once '../config/database.php';
$page_title = 'Daftar';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        
        $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
        redirect(APP_URL . '/auth/login.php');
    } catch (PDOException $e) {
        $error = "Email sudah terdaftar";
    }
}
?>

<div class="auth-container">
    <h1>Daftar Akun</h1>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if(isset($error)): ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Daftar</button>
    </form>
    
    <p class="auth-link">Sudah punya akun? <a href="login.php">Login disini</a></p>
</div>

<?php include '../includes/footer.php'; ?>