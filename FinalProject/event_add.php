<?php
include("includes/config.php");

if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
}
?>
<html>
<head>
  <link rel="stylesheet" href="assets/event_add.css">
</head>
<body>
  <div class="navbar">
    <h1>Add Event</h1>
    <a href="events.php">Back</a>
  </div>
  <div class="container">
    <form id="eventAddForm" enctype="multipart/form-data">
      <input type="text" name="judul" placeholder="Judul Event" required><br>
      <textarea name="deskripsi" placeholder="Deskripsi" required></textarea><br>
      <input type="text" name="link_pendaftaran" placeholder="Link Pendaftaran"><br>
      <input type="file" name="gambar"><br>
      <button type="submit">Tambah Event</button>
    </form>
    <div id="msg"></div>
  </div>
  <div class="footer">
    <p>&copy; 2026 ITHB Talk</p>
  </div>
  <script src="assets/event_add.js"></script>
</body>
</html>
