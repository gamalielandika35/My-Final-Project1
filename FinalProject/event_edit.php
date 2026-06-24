<?php
include("includes/config.php");

$id = $_GET['id'] ?? 0;
$stmt = mysqli_prepare($conn, "SELECT * FROM events WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
?>

<html>
<head>
  <link rel="stylesheet" href="assets/event_edit.css">
</head>
<body>
  <div class="navbar">
    <h1>Edit Event</h1>
    <a href="events.php">Back</a>
  </div>
  <div class="container">
    <form id="eventEditForm" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
      <p>Judul saat ini:</p>
      <input type="text" name="judul" value="<?php echo $data['judul']; ?>" required><br>
      <p>Deskripsi saat ini:</p>
      <textarea name="deskripsi" required><?php echo $data['deskripsi']; ?></textarea><br>
      <p>Link Pendaftaran saat ini:</p>
      <input type="text" name="link_pendaftaran" value="<?php echo $data['link_pendaftaran']; ?>"><br>
      <p>Gambar saat ini:</p>
      <?php if($data['gambar']){ ?>
        <img src="uploads/events/<?php echo $data['gambar']; ?>" style="max-width:200px;">
      <?php } ?>
      <input type="file" name="gambar"><br>
      <button type="submit">Update Event</button>
    </form>
    <div id="msg"></div>
  </div>
  <div class="footer">
    <p>&copy; 2026 ITHB Talk</p>
  </div>
  <script src="assets/event_edit.js"></script>
</body>
</html>
