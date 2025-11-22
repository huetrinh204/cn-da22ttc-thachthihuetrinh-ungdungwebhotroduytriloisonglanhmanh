<?php
include "../config.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $pdo->prepare("DELETE FROM habit WHERE id=? LIMIT 1");
    $stmt->execute([$id]);

    header("Location: habits.php");
    exit;
}
?>
