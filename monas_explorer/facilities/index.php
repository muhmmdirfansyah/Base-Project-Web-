<?php
require_once '../config/database.php';
$page_title = 'Fasilitas Monas';
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM facilities");
?>

<h1>Fasilitas di Monas</h1>

<div class="facilities-grid">
    <?php while ($facility = $stmt->fetch()): ?>
        <div class="facility-card">
            <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($facility['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($facility['name']); ?>">
            <div class="facility-info">
                <h2><?php echo htmlspecialchars($facility['name']); ?></h2>
                <p><strong>Lokasi:</strong> <?php echo ucfirst(htmlspecialchars($facility['location'])); ?></p>
                <p><strong>Jam Buka:</strong> <?php echo htmlspecialchars($facility['opening_hours']); ?></p>
                <a href="detail.php?id=<?php echo $facility['id']; ?>" class="btn">Lihat Detail</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>