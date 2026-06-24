<?php
include("includes/config.php");

$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$root = $dom->createElement('users');
$dom->appendChild($root);

while ($row = mysqli_fetch_assoc($result)) {
    $user = $dom->createElement('user');

    $user->appendChild($dom->createElement('id', $row['id']));
    $user->appendChild($dom->createElement('username', $row['username']));
    $user->appendChild($dom->createElement('nama_lengkap', $row['nama_lengkap']));
    $user->appendChild($dom->createElement('nim', $row['nim']));
    $user->appendChild($dom->createElement('jurusan', $row['jurusan']));
    $user->appendChild($dom->createElement('angkatan', $row['angkatan']));
    $user->appendChild($dom->createElement('role', $row['role']));
    $user->appendChild($dom->createElement('created_at', $row['created_at']));

    $root->appendChild($user);
}

file_put_contents("assets/users.xml", $dom->saveXML());
?>
