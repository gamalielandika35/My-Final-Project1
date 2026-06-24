<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql    = "SELECT * FROM users WHERE id = ?";
$stmt   = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data   = mysqli_fetch_assoc($result);

$foto_profil = !empty($data['foto_profil']) 
    ? 'uploads/profil/' . $data['foto_profil'] 
    : 'uploads/profil/default.jpeg';
// Perbaikan foto default sudah berhasil, masalahnya terletak di set default di tabel users

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
     <header class="navbar">
    <h1>ITHB Talk</h1>
    <nav>
      <a href="home.php">Home</a>
      <a href="events.php">Events</a>
      <a href="curhatan.php">Curhatan</a>
      <a href="ukm_list.php">UKM</a>
      <a href="calculate.php">Calculate</a>
      <a href="account.php">Profile</a>
    </nav>
  </header>
     
<head>
  <meta charset="UTF-8">
  <title>MY PROFILE - ITHBTALK</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="assets/account.css">
  <script></script>
</head>
<body>
   
   <div class="profile-box">
    <h2>MY PROFILE</h2>
    <div class="profile-pic">
      <img src="<?php echo $foto_profil; ?>">
    </div>

   <!-- Tambahan -->
    <div class="view-section">
      <span class="label">Username :</span>
      <span class="value"><?php echo htmlspecialchars($data['username']); ?></span>
    </div>


    <div class="view-section">
      <span class="label">Nama Lengkap :</span>
      <span class="value"><?php echo htmlspecialchars($data['nama_lengkap']); ?></span>
    </div>

    <div class="view-section">
      <span class="label">NIM :</span>
      <span class="value"><?php echo $data['nim'] ?? '-'; ?></span>
    </div>

    <div class="view-section">
      <span class="label">Jurusan :</span>
      <span class="value"><?php echo $data['jurusan'] ?? '-'; ?></span>
    </div>

    <div class="view-section">
      <span class="label">Angkatan :</span>
      <span class="value"><?php echo $data['angkatan'] ?? '-'; ?></span>
    </div>

    <div class="view-section">
      <span class="label">Bio :</span>
      <span class="value"><?php echo nl2br(htmlspecialchars($data['bio'] ?? 'Belum ada bio.')); ?></span>
    </div>
    
    <!-- Status akun dihapus -->

    <div class="actions">
      <a href="account_edit.php"><button>Edit Profile</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>
  </div>
  <footer class="footer">
    <div class="socials">
      <a href="#" class="social-btn instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" class="social-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
      <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
    </div>
    <p>&copy; 2026 ITHB Talk</p>
  </footer>

</body>
 
</html>
