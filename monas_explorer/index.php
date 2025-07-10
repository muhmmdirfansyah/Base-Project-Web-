<?php
require_once 'config/database.php';
$page_title = 'Beranda';
include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h2>Selamat Datang di Monas Explorer</h2>
        <p>Jelajahi keindahan dan sejarah Monumen Nasional</p>
        <a href="<?php echo APP_URL; ?>/articles/" class="btn">Lihat Artikel</a>
    </div>
</section>

<section class="featured-articles">
    <h2 class="section-title">Artikel Terbaru</h2>
    <div class="articles-grid">
        <?php
        $stmt = $pdo->query("SELECT articles.*, users.username 
                            FROM articles 
                            JOIN users ON articles.author_id = users.id 
                            ORDER BY created_at DESC LIMIT 3");
        while ($article = $stmt->fetch()): ?>
            <article class="article-card">
                <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($article['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($article['title']); ?>">
                <div class="article-content">
                    <span class="category"><?php echo htmlspecialchars($article['category']); ?></span>
                    <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($article['content']), 0, 100); ?>...</p>
                    <a href="<?php echo APP_URL; ?>/articles/detail.php?id=<?php echo $article['id']; ?>" class="btn">Baca Selengkapnya</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<section class="featured-facilities">
    <h2 class="section-title">Fasilitas Populer</h2>
    <div class="facilities-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM facilities ORDER BY RAND() LIMIT 2");
        while ($facility = $stmt->fetch()): ?>
            <div class="facility-card">
                <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($facility['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($facility['name']); ?>">
                <div class="facility-info">
                    <h3><?php echo htmlspecialchars($facility['name']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($facility['description']), 0, 100); ?>...</p>
                    <a href="<?php echo APP_URL; ?>/facilities/detail.php?id=<?php echo $facility['id']; ?>" class="btn">Lihat Detail</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>