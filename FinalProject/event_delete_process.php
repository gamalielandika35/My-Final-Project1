<?php
include("includes/config.php");
session_start();
header("Content-Type: application/xml");

$id      = $_POST['id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? 0;
$role    = $_SESSION['role'] ?? '';

if ($id && $user_id) {
    // admin boleh hapus semua, pemegang_event hanya hapus miliknya
    if ($role == 'admin') {
        $stmt = mysqli_prepare($conn, "DELETE FROM events WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
    } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM events WHERE id=? AND user_id=?");
        mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "<response><status>success</status><message>Event berhasil dihapus</message></response>";
    } else {
        echo "<response><status>error</status><message>Error: ".mysqli_error($conn)."</message></response>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<response><status>error</status><message>ID tidak valid</message></response>";
}
?>
