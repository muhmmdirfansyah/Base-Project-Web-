<?php
require_once '../config/database.php';

if (!is_logged_in()) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    redirect(APP_URL . '/auth/login.php');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Get user reviews
$reviews_stmt = $pdo->prepare("SELECT reviews.*, facilities.name as facility_name 
                              FROM reviews 
                              JOIN facilities ON reviews.facility_id = facilities.id 
                              WHERE user_id = ? 
                              ORDER BY created_at DESC");
$reviews_stmt->execute([$_SESSION['user_id']]);

$page_title = 'Profil Pengguna';
include '../includes/header.php';
?>

<div class="profile-container">
    <div class="profile-header">
        <h1>Profil <?php echo htmlspecialchars($user['username']); ?></h1>
        <p>Member sejak: <?php echo date('d F Y', strtotime($user['created_at'])); ?></p>
    </div>
    
    <div class="profile-content">
        <div class="profile-info">
            <h2>Informasi Akun</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            
            <h2>Ulasan Saya</h2>
            <?php if ($reviews_stmt->rowCount() > 0): ?>
                <div class="reviews-list">
                    <?php while ($review = $reviews_stmt->fetch()): ?>
                        <div class="review-item">
                            <h3><?php echo htmlspecialchars($review['facility_name']); ?></h3>
                            <div class="review-rating">
                                <?php echo str_repeat('★', $review['rating']); ?><?php echo str_repeat('☆', 5 - $review['rating']); ?>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                            <small><?php echo date('d M Y', strtotime($review['created_at'])); ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Anda belum memberikan ulasan apapun.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>