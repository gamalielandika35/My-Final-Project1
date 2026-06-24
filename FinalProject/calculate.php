<?php
include("includes/config.php");
if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'guest') {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Ambil riwayat nilai untuk ditampilkan di tabel
$query = "SELECT * FROM nilai_matkul WHERE user_id = ? ORDER BY semester DESC";
$stmt  = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
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
    <title>Kalkulator Nilai - Buang Terkecil</title>
    <link rel= "stylesheet" href="assets/calculate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <br>
    <form action="simpan_kalkulator.php" method="POST" class="form-box">
        <h2>Input Nilai Matkul</h2>
        <p>Masukkan nama matkul</p>
        <input type="text" name="nama_matkul" placeholder="Nama Mata Kuliah" required><br><br>
        <p>Masukkkan Semester </p>
        <input type="number" name="semester" placeholder="Semester" min="1" required><br><br>
        <p>Masukkan SKS</p>
        <input type="number" name="sks" placeholder="SKS" min="1" max="6" required><br><br>

        <label>Masukkan 5 Nilai Kuis:</label>
        <div class="kuis-group">
            <input type="number" name="kuis[]" placeholder="K1" min="0" max="100" required>
            <input type="number" name="kuis[]" placeholder="K2" min="0" max="100" required>
            <input type="number" name="kuis[]" placeholder="K3" min="0" max="100" required>
            <input type="number" name="kuis[]" placeholder="K4" min="0" max="100" required>
            <input type="number" name="kuis[]" placeholder="K5" min="0" max="100" required>
        </div>

        <div style="margin-top: 10px;">
            <label>Nilai UTS:</label>
            <input type="number" name="uts" placeholder="UTS" min="0" max="100" required style="width: 80px;">

            <label>Nilai UAS:</label>
            <input type="number" name="uas" placeholder="UAS" min="0" max="100" required style="width: 80px;">
        </div>

        <button type="submit">Simpan & Hitung</button>
        <input type="hidden" id="user_role" value="<?php echo $_SESSION['role']; ?>">

    </form>

    <h3>Riwayat Nilai</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Matkul</th>
            <th>Sem</th>
            <th>SKS</th>
            <th>Rata-rata</th>
            <th>Indeks</th>
            <th>Bobot</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                <td><?= $row['semester'] ?></td>
                <td><?= $row['sks'] ?></td>
                <td><?= $row['nilai_rata_rata'] ?></td>
                <td><?= $row['indeks'] ?></td>
                <td><?= $row['bobot_indeks'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    
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