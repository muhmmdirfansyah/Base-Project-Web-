<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    redirect(APP_URL . '/facilities/');
}

$stmt = $pdo->prepare("SELECT * FROM facilities WHERE id = ?");
$stmt->execute([$_GET['id']]);
$facility = $stmt->fetch();

if (!$facility) {
    redirect(APP_URL . '/facilities/');
}

// Get reviews
$reviews_stmt = $pdo->prepare("SELECT reviews.*, users.username 
                              FROM reviews 
                              JOIN users ON reviews.user_id = users.id 
                              WHERE facility_id = ? 
                              ORDER BY created_at DESC");
$reviews_stmt->execute([$facility['id']]);

// Calculate average rating
$avg_stmt = $pdo->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE facility_id = ?");
$avg_stmt->execute([$facility['id']]);
$avg_rating = $avg_stmt->fetch()['avg_rating'];

$page_title = $facility['name'];
include '../includes/header.php';
?>

<section class="facility-detail">
    <div class="facility-header">
        <h1><?php echo htmlspecialchars($facility['name']); ?></h1>
        <span class="location"><?php echo ucfirst(htmlspecialchars($facility['location'])); ?></span>
    </div>
    
    <div class="facility-content">
        <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($facility['image_url']); ?>" 
             alt="<?php echo htmlspecialchars($facility['name']); ?>" class="facility-image">
        
        <div class="facility-description">
            <h2>Deskripsi</h2>
            <p><?php echo nl2br(htmlspecialchars($facility['description'])); ?></p>
            
            <h2>Jam Operasional</h2>
            <p><?php echo htmlspecialchars($facility['opening_hours']); ?></p>
            
            <?php if ($avg_rating): ?>
                <h2>Rating</h2>
                <div class="rating">
                    <?php
                    $full_stars = floor($avg_rating);
                    $half_star = ($avg_rating - $full_stars) >= 0.5;
                    
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $full_stars) {
                            echo '★';
                        } elseif ($i == $full_stars + 1 && $half_star) {
                            echo '½';
                        } else {
                            echo '☆';
                        }
                    }
                    ?>
                    <span>(<?php echo round($avg_rating, 1); ?>/5 dari <?php echo $reviews_stmt->rowCount(); ?> ulasan)</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="reviews-section">
        <h2>Ulasan Pengunjung</h2>
        
        <?php if(is_logged_in()): ?>
            <form action="submit_review.php" method="POST" class="review-form">
                <input type="hidden" name="facility_id" value="<?php echo $facility['id']; ?>">
                
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating" required>
                        <option value="5">★★★★★</option>
                        <option value="4">★★★★☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="1">★☆☆☆☆</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="comment">Ulasan Anda:</label>
                    <textarea name="comment" id="comment" rows="4" required></textarea>
                </div>
                
                <button type="submit" class="btn">Kirim Ulasan</button>
            </form>
        <?php else: ?>
            <p><a href="<?php echo APP_URL; ?>/auth/login.php">Login</a> untuk memberikan ulasan.</p>
        <?php endif; ?>
        
        <div class="reviews-list">
            <?php while ($review = $reviews_stmt->fetch()): ?>
                <div class="review-item">
                    <div class="review-header">
                        <strong><?php echo htmlspecialchars($review['username']); ?></strong>
                        <span class="review-rating">
                            <?php echo str_repeat('★', $review['rating']); ?><?php echo str_repeat('☆', 5 - $review['rating']); ?>
                        </span>
                        <small><?php echo date('d M Y', strtotime($review['created_at'])); ?></small>
                    </div>
                    <div class="review-comment">
                        <?php echo nl2br(htmlspecialchars($review['comment'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>