<?php
// Veritabanı bağlantısı
require_once('baglan.php');

// Yeni görev ekleme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    $task_name = $_POST['task'];
    $sql_insert = "INSERT INTO gorevler (task_name) VALUES (?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("s", $task_name);
    
    if ($stmt->execute()) {
        // Ekleme başarılı, sayfayı yenile
        header("Location: index.php");
        exit();
    } else {
        echo "Hata: " . $stmt->error;
    }
}

// Görevleri veritabanından çekme
$sql_select = "SELECT * FROM gorevler ORDER BY created_at DESC";
$result = $conn->query($sql_select);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yapılacaklar Listesi</title>
    <style>
/* Genel Sayfa Ayarları */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    color: #4a4a4a;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    width: 100%;
    max-width: 500px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

h1 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 30px;
    color: #d6540c;
}

/* Form Tasarımı */
.add-task-form {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
}

.add-task-form input[type="text"] {
    flex-grow: 1;
    padding: 12px;
    border: 2px solid #ffccb8;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.add-task-form input[type="text"]:focus {
    outline: none;
    border-color: #fda085;
}

.add-task-form button {
    padding: 12px 20px;
    border: none;
    background: #fda085;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.add-task-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(253, 160, 133, 0.4);
}

/* Görev Listesi Tasarımı */
.todo-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.todo-list li {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px dashed #e0e0e0;
    transition: transform 0.2s ease-in-out;
}

.todo-list li:hover {
    transform: translateX(5px);
}

.todo-list li:last-child {
    border-bottom: none;
}

/* Checkbox ve Metin Stilleri */
.task-toggle-link {
    width: 26px;
    height: 26px;
    border: 2px solid #ff9999;
    border-radius: 50%;
    margin-right: 15px;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

.todo-list li.completed .task-toggle-link {
    background-color: #2ecc71;
    border-color: #2ecc71;
}

.todo-list li.completed .task-toggle-link::after {
    content: '\2713';
    color: white;
    font-size: 16px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.todo-list li.completed span {
    text-decoration: line-through;
    color: #bbb;
    font-style: italic;
}
/* Silme butonu tasarımı */
.delete-link {
    margin-left: auto; /* Görevi ve kutucuğu sola, silme butonunu sağa iter */
    color: #e74c3c;
    text-decoration: none;
    font-size: 0.9em;
    padding: 5px 10px;
    border: 1px solid #e74c3c;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.delete-link:hover {
    background-color: #e74c3c;
    color: white;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Yapılacaklar Listesi</h1>
        
        <form class="add-task-form" action="index.php" method="post">
            <input type="text" name="task" placeholder="Yeni görev ekle..." required>
            <button type="submit">Ekle</button>
        </form>

   <ul class="todo-list">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Görev tamamlandıysa 'completed' sınıfını ekle
            $completed_class = $row['completed'] ? 'completed' : '';
    ?>
            <li class="<?php echo $completed_class; ?>">
                <a href="toggle_task.php?id=<?php echo $row['id']; ?>" class="task-toggle-link"></a>
                <span><?php echo htmlspecialchars($row['task_name']); ?></span>
                
                <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="delete-link">Sil</a>
            </li>
    <?php
        }
    } else {
        echo '<p style="text-align:center; color:#888;">Henüz yapılacak bir şey yok.</p>';
    }
    ?>
</ul>
    </div>
</body>
</html>