<?php
session_start();
include("includes/config.php");
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$userId   = $_SESSION['user_id'] ?? 0;
$userRole = $_SESSION['role'] ?? 'member';

$cari = $_GET['cari'] ?? '';

if ($cari != "") {
    $sql = "SELECT * FROM ukm WHERE nama_ukm LIKE '%" . mysqli_real_escape_string($conn, $cari) . "%' ORDER BY nama_ukm ASC";
} else {
    $sql = "SELECT * FROM ukm ORDER BY nama_ukm ASC";
}
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="id">
     <header class="navbar">
    <h1>ITHB Talk</h1>
    <nav>
      <a href="home.php">Home</a>
      <a href="events.php">Events</a>
      <a href="curhatan.php">Curhatan</a>
      <a href="ukm_list.php">UKM</a>
      <a href="calculate.php">Calculate</a>
        <?php if($_SESSION['role'] != 'guest'){ ?>
      <a href="account.php">Profile</a>
    <?php } else { ?>
      <a href="index.php">Login</a>
    <?php } ?>
    </nav>
  </header>

<head>
    <meta charset="UTF-8">
    <title>Daftar UKM - ITHBTalk</title>
    <link rel="stylesheet" href="assets/ukm.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>


    <h2>Daftar UKM Kampus</h2>

    <?php if ($userRole === 'admin' || $userRole === 'pemegang_ukm'): ?>
        <a href="ukm_add.php" class="btn btn-add">+ Tambah UKM Baru</a>
    <?php endif; ?>

    <h2>Daftar UKM Kampus</h2>

<form method="GET" action="ukm_list.php" style="margin-bottom:20px;">
    <input type="text" name="cari" placeholder="Cari UKM..." value="<?= htmlspecialchars($cari) ?>">
    <button type="submit">Cari</button>
</form>


    <div class="ukm-container">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="ukm-card">
                <?php if (!empty($row['gambar']) && file_exists('uploads/ukm/' . $row['gambar'])): ?>
                    <img src="uploads/ukm/<?= htmlspecialchars($row['gambar']) ?>">
                <?php else: ?>
                    <div style="height:150px; background:#eee; text-align:center; line-height:150px; color:#999; border-radius:5px;">
                        No Image
                    </div>
                <?php endif; ?>

                <h3><?= htmlspecialchars($row['nama_ukm']) ?></h3>
                <p><?= htmlspecialchars($row['deskripsi']) ?></p>
                
                <div class="ukm-action">
                    <?php if (!empty($row['link_pendaftaran'])): ?>
                        <a href="<?= htmlspecialchars($row['link_pendaftaran']) ?>" target="_blank" class="link-web">Kunjungi Website &rarr;</a>
                    <?php endif; ?>
                    <br>
                    <?php if ($userRole === 'admin' || ($userRole === 'pemegang_ukm' && $row['user_id'] == $userId)): ?>
                        <a href="ukm_edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="ukm_hapus.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Hapus UKM ini?')">Hapus</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>


    

</body>
<footer class="footer">
    <div class="socials">
      <a href="#" class="social-btn instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" class="social-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
      <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
    </div>
    <p>&copy; 2026 ITHB Talk</p>
  </footer>

</html>