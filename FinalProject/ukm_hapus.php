<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'pemegang_ukm')) {
    die("Akses Ditolak! Anda tidak memiliki izin untuk menghapus data.");
}

if (isset($_GET['id'])) {
    $ukmId = (int)$_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM ukm WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $ukmId);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ukm_list.php?message=deleted");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: ukm_list.php");
    exit;
}
?>
