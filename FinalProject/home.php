<?php
include("includes/config.php");
if(!isset($_SESSION['nama_lengkap'])){ // ganti username jadi nama_lengkap
    header("Location: index.php");
    exit;
}
?>
<html>
<head>
  <link rel="stylesheet" href="assets/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
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

  <div class="container">
    <section class="card welcome">
      <h2>Welcome, <?php echo $_SESSION['nama_lengkap']; ?>!</h2>
      <p>Good morning, <?php echo $_SESSION['username']; ?>. Here's what's happening today.</p>
    </section>

    <section class="card slider">
      <?php
  $result = mysqli_query($conn, "SELECT gambar FROM events ORDER BY created_at DESC LIMIT 5");
  while ($row = mysqli_fetch_assoc($result)) {
      echo '<div class="slide"><img src="uploads/events/'.$row['gambar'].'" alt="Event"></div>';
  }
  ?>
      <div class="bullets"></div>
    </section>

    <section class="quick-access">
      <a href="events.php"><i class="fa fa-calendar"></i><span>Events</span></a>
      <a href="ukm_list.php"><i class="fa fa-users"></i><span>UKM</span></a>
      <a href="curhatan.php"><i class="fa fa-comments"></i><span>Curhatan</span></a>
      <a href="calculate.php"><i class="fa fa-calculator"></i><span>Calculate</span></a>
    </section>

    <section class="card about">
      <h3>About Us</h3>
      <p>Platform ini dibuat untuk mempermudah mahasiswa dan komunitas kampus dalam berbagi informasi event,
         memperkuat konektivitas, dan mendukung kolaborasi.</p>
      <div class="values">
        <div><h4>Excellence</h4><p>Top-tier service quality</p></div>
        <div><h4>Community</h4><p>Global network access</p></div>
      </div>
    </section>
  </div>

  <footer class="footer">
    <div class="socials">
      <a href="#" class="social-btn instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" class="social-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
      <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
    </div>
    <p>&copy; 2026 ITHB Talk</p>
  </footer>

  <script src="assets/home.js"></script>
</body>
</html>
