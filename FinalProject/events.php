<?php
include("includes/config.php");
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
}
?>
<html>
<head>
  <link rel="stylesheet" href="assets/events.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/events.js"></script>
</head>
<body>
<header class="navbar">
  <h2>
    ITHB Talk
    <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pemegang_event'){ ?>
      <a href="event_add.php">+ Add Event</a>
    <?php } ?>
  </h2>
  <nav >
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

<div class="list">
<?php
echo "<h2>Upcoming Events</h2>";

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY created_at DESC");

while ($row = mysqli_fetch_assoc($result)) {
  echo "<div class='item'>";
  echo "<div class='head'>";
  echo "<div class='name'>".$row['judul']."</div>";
  echo "<div class='meta'>";

  if ($_SESSION['role']=='admin' || $_SESSION['role']=='pemegang_event') {
    echo "<span class='badge'><a href='event_edit.php?id=".$row['id']."' class='edit-link'>Edit</a></span>";
    echo "<span class='badge'><button type='button' class='delete-btn' data-id='".$row['id']."'>Delete</button></span>";
  }

  echo "<span class='chev'>&#9660;</span>";
  echo "</div></div>";
  echo "<div class='panel'>";

  if ($row['gambar']) {
    echo "<div class='images'><img src='uploads/events/".$row['gambar']."' alt='Poster'></div>";
  }

  echo "<p>".$row['deskripsi']."</p>";

  if ($row['link_pendaftaran']) {
    echo "<a class='link-btn' href='".$row['link_pendaftaran']."' target='_blank'>Daftar di sini</a>";
  }

  echo "</div>";
  echo "</div>";
}
?>

</div>
<footer>
  <div class="socials">
    <a href="#" target="_blank" class="social-btn instagram">
      <i class="fab fa-instagram"></i>
    </a>
    <a href="#" target="_blank" class="social-btn whatsapp">
      <i class="fab fa-whatsapp"></i>
    </a>
    <a href="#" target="_blank" class="social-btn facebook">
      <i class="fab fa-facebook-f"></i>
    </a>
  </div>
  <p>&copy; 2026 ITHB Talk</p>
</footer>
</body>
</html>

