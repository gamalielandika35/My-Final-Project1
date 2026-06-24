<?php
include("includes/config.php");
header('Content-Type: application/xml');
error_reporting(E_ERROR | E_PARSE);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$nama     = $_POST['nama_lengkap'] ?? '';
$nim      = $_POST['nim'] ?? '';
$jurusan  = $_POST['jurusan'] ?? '';
$angkatan = $_POST['angkatan'] ?? '';

if ($username && $password && $nama && $nim && $jurusan && $angkatan) {

    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        echo "<response><status>error</status><message>Username sudah dipakai</message></response>";
        exit;
    }
    $role = "member";
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (username,password,nama_lengkap,nim,jurusan,angkatan,role) VALUES (?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "sssssis", $username, $hash, $nama, $nim, $jurusan, $angkatan, $role);

    if (mysqli_stmt_execute($stmt)) {
        echo "<response><status>success</status><message>Register berhasil sebagai ".$role."</message></response>";
        include 'export_users_to_xml.php'; // masukin ke xml 
    } else {
        echo "<response><status>error</status><message>Error: ".mysqli_error($conn)."</message></response>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<response><status>error</status><message>Field tidak boleh kosong</message></response>";
}
?>
