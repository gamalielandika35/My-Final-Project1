<html>
<head>
  <link rel="stylesheet" href="assets/auth.css">
</head>
<body>
  <div class="card">
    <h2>Login</h2>
    <form id="loginForm">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>
  <form method="post" action="alogin.php">
  <button type="submit" name="guest" value="1">Login as Guest</button>
</form>


<div id="msg"></div>

    <p>Belum punya akun? <a href="register.php">Register di sini</a></p>
    <div id="msg"></div>
  </div>
  <script src="assets/script.js"></script>
</body>
</html>