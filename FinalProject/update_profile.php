<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}

$user_id    = $_SESSION['user_id'];
$nama       = mysqli_real_escape_string($conn, $_POST['nama']);
$bio        = mysqli_real_escape_string($conn, $_POST['bio']);

$foto_profil = "";

// cek upload foto
if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
    $file_name = time().'_'.basename($_FILES['foto_profil']['name']);
    $target    = "uploads/profil/".$file_name;
    if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target)) {
        $foto_profil = $file_name;
    }
}

// update query
if ($foto_profil != "") {
    $sql = "UPDATE users 
            SET nama_lengkap='$nama', bio='$bio', foto_profil='$foto_profil' 
            WHERE id='$user_id'";
} else {
    $sql = "UPDATE users 
            SET nama_lengkap='$nama', bio='$bio'
            WHERE id='$user_id'";
}

if (mysqli_query($conn, $sql)) {
    header("Location: account.php");
    exit();
} else {
    echo "Database error: " . mysqli_error($conn);
}
?>
