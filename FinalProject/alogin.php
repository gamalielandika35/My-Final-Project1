<?php
include("includes/config.php");
header('Content-Type: application/xml');

if (isset($_POST['guest'])) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['username'] = "Guest";
    $_SESSION['role']     = "guest";
    $_SESSION['nama_lengkap'] = "Guest User"; // tambahan
    header("Location: home.php");
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username && $password) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            echo "<response><status>success</status><message>Login berhasil</message></response>";
        } else {
            echo "<response><status>error</status><message>Password salah</message></response>";
        }
    } else {
        echo "<response><status>error</status><message>Username tidak ditemukan</message></response>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<response><status>error</status><message>Field tidak boleh kosong</message></response>";
}
?>
