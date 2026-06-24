<html>
<head>
  <link rel="stylesheet" href="assets/auth.css">
</head>
<body>
  <div class="card">
    <h2>Register</h2>
    <form id="registerForm">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required><br>
      <input type="text" name="nim" placeholder="NIM" required><br>
      <input type="text" name="jurusan" placeholder="Jurusan" required><br>
      <input type="number" name="angkatan" placeholder="Angkatan" required><br>
      <button type="submit">Register</button>
    </form>
    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
    <div id="msg"></div>
  </div>
  <script src="assets/register.js"></script>
</body>
</html>
