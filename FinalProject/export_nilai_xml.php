<?php
session_start();
include 'includes/config.php';

if(!isset($_SESSION['user_id'])){
    die("Silakan login terlebih dahulu.");
}

$userId = $_SESSION['user_id'];

$query = "SELECT * FROM nilai_matkul WHERE user_id = ? ORDER BY semester DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;

$root = $dom->createElement('nilai_matkul_list');
$dom->appendChild($root);

while($row = $result->fetch_assoc()){
    $matkul = $dom->createElement('matkul');

    $matkul->appendChild($dom->createElement('id', $row['id']));
    $matkul->appendChild($dom->createElement('user_id', $row['user_id']));
    $matkul->appendChild($dom->createElement('nama_matkul', $row['nama_matkul']));
    $matkul->appendChild($dom->createElement('semester', $row['semester']));
    $matkul->appendChild($dom->createElement('sks', $row['sks']));
    $matkul->appendChild($dom->createElement('nilai_rata_rata', $row['nilai_rata_rata']));
    $matkul->appendChild($dom->createElement('indeks', $row['indeks']));
    $matkul->appendChild($dom->createElement('bobot_indeks', $row['bobot_indeks']));
    $matkul->appendChild($dom->createElement('created_at', $row['created_at']));

    $root->appendChild($matkul);
}


file_put_contents("assets/nilai_matkul.xml", $dom->saveXML());

?>
