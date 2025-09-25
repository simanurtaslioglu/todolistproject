<?php
require 'baglan.php';

// Güvenlik için, ID'nin sayısal olduğundan emin olun
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    // Görevin mevcut durumunu al
    $sql_select = "SELECT completed FROM gorevler WHERE id = $task_id";
    $result = $conn->query($sql_select);
    $row = $result->fetch_assoc();
    $current_status = $row['completed'];

    // Yeni durumu belirle (1 ise 0, 0 ise 1)
    $new_status = $current_status ? 0 : 1;

    // Veritabanında görevi güncelle
    $sql_update = "UPDATE gorevler SET completed = $new_status WHERE id = $task_id";
    $conn->query($sql_update);
}

// Kullanıcıyı ana sayfaya geri yönlendir
header("Location: index.php");
exit();
?>