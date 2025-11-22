<?php
include "../config.php";

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habit_id'])) {
    $id = $_POST['habit_id'];
    $stmt = $pdo->prepare("DELETE FROM habit WHERE habit_id=?");
    $stmt->execute([$id]);
    echo "OK";
}
?>