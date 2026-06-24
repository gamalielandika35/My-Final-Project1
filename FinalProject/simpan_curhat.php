<?php
include("includes/config.php");

// tambahan untuk guest biar gabisa post
if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'guest') {
    die("Silakan login terlebih dahulu");
}

$user_id    = $_SESSION['user_id'];
$isi_curhat = mysqli_real_escape_string($conn, $_POST['isi_curhat']);
$visibility = $_POST['visibility'];

$media_path = "";
$media_type = "none";

// cek media upload
if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
    $file_name = time() . '_' . basename($_FILES['media']['name']);
    $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (in_array($file_ext, ['jpg','jpeg','png','gif'])) {
        move_uploaded_file($_FILES['media']['tmp_name'], "uploads/curhatan/images/" . $file_name);
        $media_path = $file_name;
        $media_type = ($file_ext == 'gif') ? 'gif' : 'image';
    } elseif (in_array($file_ext, ['mp4','webm','mov'])) {
        move_uploaded_file($_FILES['media']['tmp_name'], "uploads/curhatan/videos/" . $file_name);
        $media_path = $file_name;
        $media_type = 'video';
    }
}

// simpan ke db
$sql = "INSERT INTO curhatan (user_id, isi_curhat, visibility, media_path, media_type) 
        VALUES ('$user_id', '$isi_curhat', '$visibility', '$media_path', '$media_type')";

if (mysqli_query($conn, $sql)) {
    echo "sukses";
} else {
    echo "Database error: " . mysqli_error($conn);
}
?>
