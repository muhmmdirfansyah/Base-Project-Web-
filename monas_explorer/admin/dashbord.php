<?php 
require_once '../includes/admin_auth_check.php';
require_once '../../config/database.php';

// Hitung total data
$stmt = $pdo->query("SELECT COUNT(*) FROM articles");
$total_articles = $stmt->fetchColumn();

// ... (query lainnya untuk facilities, users, dll)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <?php include '../includes/header.php'; ?>
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <!-- Navigasi Admin -->
        </div>
        <div class="main-content">
            <h1>Dashboard Admin</h1>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Artikel</h3>
                    <p><?= $total_articles ?></p>
                </div>
                <!-- Statistik lainnya -->
            </div>
            <!-- Grafik menggunakan Chart.js -->
            <canvas id="visitorChart"></canvas>
        </div>
    </div>
    <script src="../assets/js/chart.js"></script>
</body>
</html>