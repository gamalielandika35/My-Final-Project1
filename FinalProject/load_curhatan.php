<?php
include("includes/config.php");

$current_user = $_SESSION['user_id'] ?? 0;

// data terbaru
$sql = "SELECT c.*, u.username 
        FROM curhatan c 
        JOIN users u ON c.user_id = u.id 
        ORDER BY c.created_at DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $post_id = $row['id'];
        
        // total Like
        $res_like    = mysqli_query($conn, "SELECT COUNT(*) as total FROM likes_curhatan WHERE curhatan_id = $post_id");
        $like_row    = mysqli_fetch_assoc($res_like);
        $total_likes = $like_row['total'];

        // Cek ngelike 
        $res_check = mysqli_query($conn, "SELECT * FROM likes_curhatan WHERE user_id = $current_user AND curhatan_id = $post_id");
        $icon_class = (mysqli_num_rows($res_check) > 0) ? 'fa-solid' : 'fa-regular';
        $icon_color = (mysqli_num_rows($res_check) > 0) ? 'color: #ff4d4d;' : 'color: #bbb;';

        
        echo '<div class="post" style="background:#2a2a2a; padding:15px; border-radius:10px; margin-bottom:15px;">';
        echo '  <h4 style="color:#ffda44; margin-bottom:5px;">@' . $row['username'] . 
             ' <small style="color:#888; font-size:12px; font-weight:normal;">• ' . $row['created_at'] . '</small></h4>';
        echo '  <p style="color:#fff; margin-bottom:10px;">' . nl2br(htmlspecialchars($row['isi_curhat'])) . '</p>';
        
        if ($row['media_type'] == 'image' || $row['media_type'] == 'gif') {
            echo '<img src="uploads/curhatan/images/' . $row['media_path'] . '" style="max-width:100%; border-radius:8px; margin-bottom:10px;">';
        } elseif ($row['media_type'] == 'video') {
            echo '<video src="uploads/curhatan/videos/' . $row['media_path'] . '" controls style="max-width:100%; border-radius:8px; margin-bottom:10px;"></video>';
        }

        // Tombol Like
        echo '  <div class="post-actions">';
        echo '      <button class="btn-like" data-id="' . $post_id . '" style="background:none; border:none; cursor:pointer; color:#fff; font-size:16px;">';
        echo '          <i class="' . $icon_class . ' fa-heart" style="' . $icon_color . '"></i> <span class="like-count">' . $total_likes . '</span>';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<p style="text-align:center; color:#888;">Belum ada curhatan. Jadilah yang pertama!</p>';
}
?>
