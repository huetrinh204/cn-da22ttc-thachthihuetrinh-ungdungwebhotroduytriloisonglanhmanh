<?php
session_start();
include "config.php";  // cần $pdo

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra đăng nhập
$user_id = $_SESSION["user_id"] ?? null;
if (!$user_id) {
    echo json_encode(["status" => "not_login"]);
    exit();
}

$action = $_GET["action"] ?? "";


/* ======================================================
   1) TẠO BÀI ĐĂNG (PDO)
====================================================== */
if ($action === "create_post") {

    $title   = trim($_POST["title"] ?? "");
    $content = trim($_POST["content"] ?? "");

    if ($title === "" || $content === "") {
        echo json_encode(["status" => "empty"]);
        exit();
    }

    $stmt = $pdo->prepare("
        INSERT INTO post (title, content, created_at, user_id)
        VALUES (?, ?, NOW(), ?)
    ");
    $stmt->execute([$title, $content, $user_id]);

    echo json_encode(["status" => "success"]);
    exit();
}



/* ======================================================
   2) TẠO COMMENT (PDO)
====================================================== */
if ($action === "create_comment") {

    $post_id = $_POST["post_id"] ?? null;
    $content = trim($_POST["content"] ?? "");

    if (!$post_id || $content === "") {
        echo json_encode(["status" => "error"]);
        exit();
    }

    $stmt = $pdo->prepare("
        INSERT INTO comment (post_id, user_id, content_cmt, created_cmt)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$post_id, $user_id, $content]);

    echo json_encode(["status" => "success"]);
    exit();
}



/* ======================================================
   3) LẤY DANH SÁCH BÀI ĐĂNG (PDO)
====================================================== */
if ($action === "get_posts") {

    // Lấy danh sách bài + username
    $stmt = $pdo->query("
        SELECT p.post_id, p.title, p.content, p.created_at,
               u.username
        FROM post p
        JOIN users u ON p.user_id = u.user_id
        ORDER BY p.post_id DESC
    ");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($posts as $p) {

        // Lấy comment của từng bài
        $stmt2 = $pdo->prepare("
            SELECT c.content_cmt, c.created_cmt, u.username
            FROM comment c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.post_id = ?
            ORDER BY c.cmt_id ASC
        ");
        $stmt2->execute([$p["post_id"]]);
        $comments = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $p["comments"] = $comments;
        $result[] = $p;
    }

    echo json_encode($result);
    exit();
}


echo json_encode(["status" => "invalid_action"]);
exit();
