<?php
// Veritabanı bağlantısını dahil et
require_once('baglan.php');

// Güvenlik için, ID'nin sayısal olduğundan emin olun
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    // SQL sorgusu ile görevi sil
    // Prepared Statement kullanarak güvenlik açıklarını önle
    $sql_delete = "DELETE FROM gorevler WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $task_id); // "i" integer (sayısal) bir değer beklediğimizi belirtir.
    
    if ($stmt->execute()) {
        // Silme başarılı
    } else {
        echo "Hata: " . $stmt->error;
    }
}

// İşlem bittikten sonra ana sayfaya geri yönlendir
header("Location: index.php");
exit();
?>