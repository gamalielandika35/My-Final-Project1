<?php
include("includes/config.php");
header('Content-Type: application/xml');

$id       = $_POST['id'] ?? 0;
$judul    = $_POST['judul'] ?? '';
$deskripsi= $_POST['deskripsi'] ?? '';
$link     = $_POST['link_pendaftaran'] ?? '';
$user_id  = $_SESSION['user_id'] ?? 0;

if ($id && $judul && $deskripsi) {
    $stmt = mysqli_prepare($conn, "SELECT user_id,gambar FROM events WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res   = mysqli_stmt_get_result($stmt);
    $owner = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    if ($_SESSION['role']=='admin' || $owner['user_id']==$user_id) {
        $gambar = $owner['gambar'];

    
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error']==0) {
            $targetDir = "uploads/events/";
            if (!is_dir($targetDir)) mkdir($targetDir,0777,true);
            $fileName  = time()."_".basename($_FILES['gambar']['name']);
            $targetFile= $targetDir.$fileName;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'],$targetFile)) {
                // hapus file lama
                if ($gambar && file_exists($targetDir.$gambar)) {
                    unlink($targetDir.$gambar);
                }
                $gambar = $fileName;
            }
        }

     
        $stmt = mysqli_prepare($conn, "UPDATE events SET judul=?, deskripsi=?, link_pendaftaran=?, gambar=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssi", $judul, $deskripsi, $link, $gambar, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<response><status>success</status><message>Event berhasil diupdate</message></response>";
        } else {
            echo "<response><status>error</status><message>Error: ".mysqli_error($conn)."</message></response>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<response><status>error</status><message>Tidak punya hak edit</message></response>";
    }
} else {
    echo "<response><status>error</status><message>Field tidak boleh kosong</message></response>";
}
?>
