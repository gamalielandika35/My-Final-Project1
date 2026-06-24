<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$ukmId    = (int)$_GET['id'];
$userId   = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

// ambil data UKM
$stmt  = mysqli_prepare($conn, "SELECT * FROM ukm WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $ukmId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ukm    = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$ukm || ($userRole !== 'admin' && $ukm['user_id'] != $userId)) {
    die("Akses Ditolak! Kamu tidak punya wewenang mengedit UKM ini.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = $_POST['nama_ukm'];
    $desk   = $_POST['deskripsi'];
    $link   = $_POST['link_pendaftaran'];
    $gambar = $ukm['gambar'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $ext       = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_file = time() . '_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/ukm/' . $nama_file)) {
            if (!empty($ukm['gambar']) && file_exists('uploads/ukm/' . $ukm['gambar'])) {
                unlink('uploads/ukm/' . $ukm['gambar']);
            }
            $gambar = $nama_file;
        }
    }

    $update = mysqli_prepare($conn, "UPDATE ukm SET nama_ukm=?, deskripsi=?, link_pendaftaran=?, gambar=? WHERE id=?");
    mysqli_stmt_bind_param($update, "ssssi", $nama, $desk, $link, $gambar, $ukmId);

    if (mysqli_stmt_execute($update)) {
        header("Location: ukm_list.php");
        exit;
    } else {
        echo "Gagal update UKM: " . mysqli_error($conn);
    }

    mysqli_stmt_close($update);
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit UKM - ITHBTalk</title>
    <link rel="stylesheet" href="assets/ukm.css">
</head>
<body>

    <h2 style="text-align: center;">Edit Data UKM</h2>

    <div class="form-box">
        <form method="POST" enctype="multipart/form-data">
            <label>Nama UKM</label>
            <input type="text" name="nama_ukm" value="<?= htmlspecialchars($ukm['nama_ukm']) ?>" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?= htmlspecialchars($ukm['deskripsi']) ?></textarea>

            <label>Link Website/Pendaftaran</label>
            <input type="url" name="link_pendaftaran" value="<?= htmlspecialchars($ukm['link_pendaftaran']) ?>">

            <label>Gambar Saat Ini</label>
            <?php if (!empty($ukm['gambar'])): ?>
                <img src="uploads/ukm/<?= $ukm['gambar'] ?>" class="preview-img">
            <?php else: ?>
                <div style="margin-bottom: 10px; color: #999; font-size: 12px;">Belum ada gambar.</div>
            <?php endif; ?>

            <label>Ganti Gambar</label>
            <input type="file" name="gambar" accept="image/*">

            <button type="submit" class="btn btn-submit">Update Data</button>
            <a href="ukm_list.php" class="btn-back">Batal</a>
        </form>
    </div>

</body>
</html>