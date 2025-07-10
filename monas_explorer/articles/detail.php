<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    redirect(APP_URL . '/articles/');
}

$stmt = $pdo->prepare("SELECT articles.*, users.username 
                      FROM articles 
                      JOIN users ON articles.author_id = users.id 
                      WHERE articles.id = ?");
$stmt->execute([$_GET['id']]);
$article = $stmt->fetch();

if (!$article) {
    redirect(APP_URL . '/articles/');
}

$page_title = $article['title'];
include '../includes/header.php';
?>

<article class="article-detail">
    <h1><?php echo htmlspecialchars($article['title']); ?></h1>
    <p class="meta">Ditulis oleh <?php echo htmlspecialchars($article['username']); ?> pada <?php echo date('d F Y', strtotime($article['created_at'])); ?></p>
    
    <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($article['image_url']); ?>" 
         alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-image">
    
    <div class="article-content">
        <?php echo nl2br(htmlspecialchars($article['content'])); ?>
    </div>
</article>

<section class="related-articles">
    <h2>Artikel Terkait</h2>
    <div class="articles-grid">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE category = ? AND id != ? ORDER BY RAND() LIMIT 3");
        $stmt->execute([$article['category'], $article['id']]);
        
        while ($related = $stmt->fetch()): ?>
            <article class="article-card">
                <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($related['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($related['title']); ?>">
                <h3><?php echo htmlspecialchars($related['title']); ?></h3>
                <a href="detail.php?id=<?php echo $related['id']; ?>" class="btn">Baca</a>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<?php include '../includes/footer.php'; ?>