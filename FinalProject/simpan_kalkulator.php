<?php
include 'includes/config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'guest') {
    echo json_encode([
        "status" => false,
        "message" => "Silakan login dahulu untuk menyimpan nilai."
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $namaMatkul = $_POST['nama_matkul'];
    $semester = (int) $_POST['semester'];
    $sks = (int) $_POST['sks'];

    $kuis = $_POST['kuis'];
    $uts = (float) ($_POST['uts'] ?? 0);
    $uas = (float) ($_POST['uas'] ?? 0);

    sort($kuis);
    array_shift($kuis);
    $rataRataKuis = array_sum($kuis) / count($kuis);

    $nilaiRataRata = ($rataRataKuis * 0.30) + ($uts * 0.30) + ($uas * 0.40);

   
    if ($nilaiRataRata >= 80) {
        $indeks = 'A';
        $bobot = 4.0;
    } elseif ($nilaiRataRata >= 70) {
        $indeks = 'B';
        $bobot = 3.0;
    } elseif ($nilaiRataRata >= 60) {
        $indeks = 'C';
        $bobot = 2.0;
    } elseif ($nilaiRataRata >= 50) {
        $indeks = 'D';
        $bobot = 1.0;
    } else {
        $indeks = 'E';
        $bobot = 0.0;
    }


 
    $sql = "INSERT INTO nilai_matkul (user_id, nama_matkul, semester, sks, nilai_rata_rata, indeks, bobot_indeks) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            include 'export_nilai_xml.php';


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiidsd", $userId, $namaMatkul, $semester, $sks, $nilaiRataRata, $indeks, $bobot);
    if ($stmt->execute()) {
    
        updateUserStats($conn, $userId);
        header("Location: calculate.php?success=1");
    } else {
        echo "Gagal menyimpan data.";
    }
}

function updateUserStats($conn, $userId)
{

    $query = "SELECT AVG(bobot_indeks) as new_ipk FROM nilai_matkul WHERE user_id = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $res   = mysqli_stmt_get_result($stmt);
    $row   = mysqli_fetch_assoc($res);
    $newIpk= $row['new_ipk'];
    mysqli_stmt_close($stmt);

    $update = "UPDATE users SET ipk = ? WHERE id = ?";
    $stmtUpd= mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmtUpd, "di", $newIpk, $userId);
    mysqli_stmt_execute($stmtUpd);
    mysqli_stmt_close($stmtUpd);
}