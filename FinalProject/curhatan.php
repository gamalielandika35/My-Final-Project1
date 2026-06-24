<?php
include "includes/config.php";
// Cek login
if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
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
    <title>CURHATAN - ITHBTALK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/curhatan.css">
</head>
<body>

    <div class="wrapper">
        <div class="header">Curhatan</div>

        <form id="postForm" class="tweet-box" enctype="multipart/form-data">
            <div class="tweet-box-container">
                <p style="color: #bbb; margin-bottom: 8px; font-weight: bold;">
                    @<?php echo $_SESSION['username']; ?>
                </p>
                <textarea id="postText" name="isi_curhat" placeholder="Apa yang sedang kamu pikirkan?" required></textarea>
            </div>

            <div class="tweet-actions-group">
                <input type="file" name="media" id="mediaInput" accept="image/*,video/*" style="display: none;">
                <label for="mediaInput" style="cursor: pointer; color: #3651ff; font-size: 20px;">
                    <i class="fa-solid fa-image"></i>
                </label>
                <span id="fileNameDisplay" style="color: #888; font-size: 12px; margin-left: 10px;"></span>

                <select name="visibility">
                    <option value="public">Publik</option>
                    <option value="close">Teman Terdekat</option>
                    <option value="private">Hanya Saya</option>
                </select>
                
                <button type="submit"><i class="fa-solid fa-paper-plane"></i> Post</button>
            </div>
        </form>

        <div class="section-title">Beranda Terkini</div>
        
        <div id="feed" class="feed"></div>
    </div>
    
    


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/curhatan.js"></script>
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