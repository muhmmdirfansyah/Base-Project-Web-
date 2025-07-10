<?php
require_once '../config/database.php';

if (!is_logged_in() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(APP_URL . '/facilities/');
}

$facility_id = $_POST['facility_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Validasi
if ($rating < 1 || $rating > 5 || empty($comment)) {
    $_SESSION['error'] = "Harap isi semua field dengan benar";
    redirect(APP_URL . "/facilities/detail.php?id=$facility_id");
}

try {
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, facility_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $facility_id, $rating, $comment]);
    
    $_SESSION['success'] = "Ulasan Anda telah dikirim";
} catch (PDOException $e) {
    $_SESSION['error'] = "Gagal mengirim ulasan";
}

redirect(APP_URL . "/facilities/detail.php?id=$facility_id");
?>