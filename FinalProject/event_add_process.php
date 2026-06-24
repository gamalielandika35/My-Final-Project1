<?php
session_start();
error_reporting(0);
include("includes/config.php");
header('Content-Type: application/xml');

$judul     = $_POST['judul'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';
$link      = $_POST['link_pendaftaran'] ?? '';
$user_id   = $_SESSION['user_id'] ?? 0;

$gambar = null;
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $targetDir = "uploads/events/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $fileName  = time()."_".basename($_FILES['gambar']['name']);
    $targetFile= $targetDir.$fileName;
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $gambar = $fileName;
    }
}

if ($judul && $deskripsi && $user_id) {
    $stmt = mysqli_prepare($conn, "INSERT INTO events (user_id, judul, deskripsi, link_pendaftaran, gambar) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $judul, $deskripsi, $link, $gambar);

    if (mysqli_stmt_execute($stmt)) {
        echo "<response><status>success</status><message>Event berhasil ditambahkan</message></response>";
    } else {
        echo "<response><status>error</status><message>Error: ".mysqli_error($conn)."</message></response>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<response><status>error</status><message>Field tidak boleh kosong</message></response>";
}
?>
