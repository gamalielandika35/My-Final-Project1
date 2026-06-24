<?php
// revisi tidak pakai json lebih baik pake yang udah diajarin kelas (buat ulang)
include("includes/config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Silakan login terlebih dahulu";
    exit;
}

$user_id     = $_SESSION['user_id'];
$curhatan_id = $_POST['curhatan_id'];

// cek ngelike
$cek = mysqli_query($conn, "SELECT * FROM likes_curhatan WHERE user_id='$user_id' AND curhatan_id='$curhatan_id'");

if (mysqli_num_rows($cek) > 0) {
    mysqli_query($conn, "DELETE FROM likes_curhatan WHERE user_id='$user_id' AND curhatan_id='$curhatan_id'");
    $status = "unliked";
} else {
    mysqli_query($conn, "INSERT INTO likes_curhatan (user_id, curhatan_id) VALUES ('$user_id','$curhatan_id')");
    $status = "liked";
}

// total likes
$hitung   = mysqli_query($conn, "SELECT COUNT(*) AS total FROM likes_curhatan WHERE curhatan_id='$curhatan_id'");
$totalRow = mysqli_fetch_assoc($hitung);
$total    = $totalRow['total'];

// output
echo "Status: $status, Total Likes: $total";
?>
