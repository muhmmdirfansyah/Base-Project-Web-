<?php
require_once '../config/database.php';
$page_title = 'Artikel';
include '../includes/header.php';

$category = $_GET['category'] ?? 'all';
$sql = "SELECT articles.*, users.username 
        FROM articles 
        JOIN users ON articles.author_id = users.id";

if ($category !== 'all') {
    $sql .= " WHERE category = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category]);
} else {
    $stmt = $pdo->query($sql);
}
?>

<h1>Artikel Tentang Monas</h1>

<div class="category-filter">
    <a href="?category=all" class="btn">Semua</a>
    <a href="?category=sejarah" class="btn">Sejarah</a>
    <a href="?category=arsitektur" class="btn">Arsitektur</a>
    <a href="?category=wisata" class="btn">Wisata</a>
    <a href="?category=event" class="btn">Event</a>
</div>

<div class="articles-list">
    <?php while ($article = $stmt->fetch()): ?>
        <article class="article-item">
            <img src="<?php echo APP_URL; ?>/assets/images/<?php echo htmlspecialchars($article['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($article['title']); ?>">
            <div class="article-content">
                <span class="category"><?php echo htmlspecialchars($article['category']); ?></span>
                <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                <p class="meta">Ditulis oleh <?php echo htmlspecialchars($article['username']); ?> pada <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
                <p><?php echo substr(htmlspecialchars($article['content']), 0, 200); ?>...</p>
                <a href="detail.php?id=<?php echo $article['id']; ?>" class="btn">Baca Selengkapnya</a>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>