<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'pemegang_ukm')) {
    die("Akses Ditolak! Hanya Admin atau Pemegang UKM yang bisa menambah UKM baru.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama        = $_POST['nama_ukm'];
    $desk        = $_POST['deskripsi'];
    $link        = $_POST['link_pendaftaran'];
    $pemegang_id = (int)$_POST['user_id'];

    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $ext       = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_file = time() . '_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/ukm/' . $nama_file)) {
            $gambar = $nama_file;
        }
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO ukm (user_id, nama_ukm, deskripsi, link_pendaftaran, gambar) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issss", $pemegang_id, $nama, $desk, $link, $gambar);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ukm_list.php");
        exit;
    } else {
        echo "Gagal menyimpan UKM: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

$users = mysqli_query($conn, "SELECT id, nama_lengkap FROM users WHERE role = 'pemegang_ukm'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah UKM - ITHBTalk</title>
    <link rel="stylesheet" href="assets/ukm.css">
</head>
<body>

    <h2 style="text-align: center;">Tambah UKM Baru</h2>

    <div class="form-box">
        <form method="POST" enctype="multipart/form-data">
            <label>Nama UKM</label>
            <input type="text" name="nama_ukm" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>

            <label>Link Pendaftaran</label>
            <input type="url" name="link_pendaftaran" placeholder="https://example.com">

            <label>Logo / Gambar UKM</label>
            <input type="file" name="gambar" accept="image/*">

            <label>Pilih Pemegang UKM</label>
            <select name="user_id" required>
                <option value="">-- Pilih Mahasiswa --</option>
                <?php while($u = $users->fetch_assoc()): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nama_lengkap']) ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" class="btn btn-submit">Simpan UKM</button>
            <a href="ukm_list.php" class="btn-back">Batal</a>
        </form>
    </div>

</body>
</html>