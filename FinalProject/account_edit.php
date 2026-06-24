<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION['user_id'])) {
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
    : 'uploads/profil/default.jpg';

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - ITHBTALK</title>
  <link rel="stylesheet" href="assets/account.css">
</head>
<body>
  <div class="profile-box">
    <h2>Edit Profile</h2>
    <form action="update_profile.php" method="post" enctype="multipart/form-data">
      <div class="profile-pic">
        <img src="<?php echo $foto_profil; ?>">
      </div>
      <label>Ganti Foto Profil</label>
      <input type="file" name="foto_profil" accept="image/*">

      <label>Nama Lengkap</label>
      <input type="text" name="nama" value="<?php echo $data['nama_lengkap']; ?>" required>

      <label>Bio</label>
      <textarea name="bio"><?php echo $data['bio']; ?></textarea>

      <!-- Status akun dihapus -->

      <button type="submit">Simpan Perubahan</button>
      <a href="account.php"><button type="button">Batal</button></a>
    </form>
  </div>
</body>
</html>
