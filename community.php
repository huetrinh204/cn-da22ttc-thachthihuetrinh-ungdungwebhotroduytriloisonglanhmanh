<?php
session_start();
include "config.php";

// Nếu chưa đăng nhập
if (!isset($_SESSION["user_id"])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

/* ============================================
   API MODE – tất cả xử lý backend trong 1 file
   ============================================ */
if (isset($_GET["action"])) {

    header("Content-Type: application/json; charset=UTF-8");

    /* ------------------- ĐĂNG BÀI ------------------- */
    if ($_GET["action"] === "create_post") {
        $content = trim($_POST["content"]);

        if ($content == "") {
            echo json_encode(["status" => "empty"]);
            exit();
        }

        $stmt = $conn->prepare("
            INSERT INTO post (title, content, created_at, user_id)
            VALUES ('', ?, NOW(), ?)
        ");
        $stmt->bind_param("si", $content, $user_id);
        $stmt->execute();

        echo json_encode(["status" => "success"]);
        exit();
    }

    /* ------------------- THÊM COMMENT ------------------- */
if ($_GET["action"] === "create_comment") {
    $post_id = $_POST["post_id"];
    $content = $_POST["content"];

    $stmt = $conn->prepare("INSERT INTO comment (post_id, user_id, content_cmt) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $user_id, $content);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit();
}

    /* ------------------- LẤY LIST POST ------------------- */
    if ($_GET["action"] === "get_posts") {

        $sql = "
            SELECT p.*, u.username 
            FROM post p
            JOIN users u ON p.user_id = u.user_id
            ORDER BY p.post_id DESC
        ";

        $result = $conn->query($sql);
        $posts = [];

        while ($row = $result->fetch_assoc()) {
            $pid = $row["post_id"];

            // lấy comments
            $cmt = $conn->query("
                SELECT c.content_cmt, c.created_cmt, u.username
                FROM comment c
                JOIN users u ON c.user_id = u.user_id
                WHERE c.post_id = $pid
                ORDER BY c.cmt_id ASC
            ");

            $comments = [];
            while ($c = $cmt->fetch_assoc()) {
                $comments[] = $c;
            }

            $row["comments"] = $comments;
            $posts[] = $row;
        }

        echo json_encode($posts);
        exit();
    }

    exit();
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cộng đồng</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.popup-enter { opacity:0; transform:scale(0.95); }
.popup-enter-active { opacity:1; transform:scale(1); transition:0.25s; }
.popup-exit-active { opacity:0; transform:scale(0.9); transition:0.2s; }
</style>
</head>

<body class="bg-gradient-to-br from-cyan-300 to-teal-400 min-h-screen">

<?php include "navbar.php"; ?>

<section class="container mx-auto mt-10 px-4">
<div class="bg-white/90 backdrop-blur-sm p-8 rounded-3xl shadow-xl max-w-4xl mx-auto">

    <h2 class="text-xl font-semibold text-teal-700 mb-2">Cộng Đồng Mèo Thói Quen</h2>

    <!-- FORM ĐĂNG BÀI -->
   <textarea id="createPostInput"
  placeholder="Chia sẻ câu chuyện của bạn..."
  class="w-full h-32 border border-teal-300 rounded-xl p-3 bg-gray-50"></textarea>

<button onclick="submitPost()"
  class="mt-3 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-md flex items-center gap-2">
  <i class="fa-solid fa-paper-plane"></i> Đăng Bài
</button>

    <hr class="my-6">

    <!-- Danh sách bài -->
  <div id="postContainer"></div>

</div>
</section>

<!-- POPUP -->
<div id="postDetailPopup"
     class="fixed inset-0 bg-black/40 hidden justify-center items-center p-4 z-50">

  <div id="postDetailCard"
       class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6 popup-enter">

    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold">Bài viết</h3>
      <button onclick="closePostDetail()" class="text-gray-700 text-2xl">×</button>
    </div>

    <div class="flex gap-3 mb-4">
      <img id="detailAvatar" src="assets/icons/avatar1.png" class="w-12 h-12 rounded-full">
      <div>
        <h4 id="detailName" class="font-semibold"></h4>
        <p id="detailTime" class="text-gray-500 text-sm"></p>
      </div>
    </div>

    <p id="detailContent" class="mb-4"></p>

    <div class="mb-4">
      <span><i class="fa-regular fa-comment"></i> <span id="detailCommentsCount"></span> bình luận</span>
    </div>

    <div id="commentList" class="max-h-56 overflow-y-auto space-y-3"></div>

    <textarea id="commentInput"
        placeholder="Viết bình luận..."
        class="w-full border p-3 rounded-lg mt-4"></textarea>

    <button onclick="addComment()"
        class="mt-2 px-4 py-2 bg-teal-500 text-white rounded-md">
        Gửi bình luận
    </button>

  </div>
</div>

<?php include "footer.php"; ?>

<script>

let posts = [];   // Danh sách bài viết
let selectedPost = null;

// RENDER DANH SÁCH BÀI VIẾT
function renderPostList() {
  const container = document.getElementById("postContainer");
  container.innerHTML = "";

  if (posts.length === 0) {
    container.innerHTML = `
      <p class="text-gray-600 text-center py-4">Chưa có bài viết nào.</p>
    `;
    return;
  }

  posts.forEach((post, index) => {
    const item = document.createElement("div");
    item.className =
      "bg-white rounded-2xl shadow p-5 border cursor-pointer mb-4";
    item.onclick = () => openPostDetail(post);

    item.innerHTML = `
      <div class="flex gap-3">
        <img src="${post.avatar}" class="w-12 h-12 rounded-full border">
        <div>
          <h4 class="font-semibold">${post.name}</h4>
          <p class="text-gray-500 text-sm">${post.time}</p>
        </div>
      </div>

      <p class="mt-3 text-gray-800 leading-relaxed">
        ${post.content}
      </p>

      <div class="flex gap-6 mt-4 text-gray-600">
    <span class="flex items-center gap-1">
        <i class="fa-regular fa-comment"></i> ${post.comments.length}
    </span>
</div>
    `;

    container.appendChild(item);
  });
}


// ĐĂNG BÀI
function submitPost() {
  const content = document.getElementById("createPostInput").value.trim();
  if (content === "") return;

  const form = new FormData();
  form.append("content", content);

 fetch("community.php?action=create_post", {
      method: "POST",
      body: form
  })
  .then(res => res.json())
  .then(data => {
      if (data.status === "success") {
          document.getElementById("createPostInput").value = "";
          loadPosts(); // tải lại bài từ DB
      } else {
          alert("Lỗi: " + data.status);
      }
  });
}

// Load bài từ db

function loadPosts() {
  fetch("community.php?action=get_posts")
    .then(res => res.json())
    .then(data => {
      posts = data.map(p => ({
        post_id: p.post_id, 
        avatar: "assets/icons/avatar1.png",
        name: p.username,
        time: p.created_at,
        content: p.content,
        likes: 0,
        comments: p.comments.map(c => ({
          name: c.username,
          text: c.content_cmt
        }))
      }));

      renderPostList();
    });
}


// ======== POPUP XEM CHI TIẾT ========

function openPostDetail(post) {
  selectedPost = post;

  document.getElementById("detailAvatar").src = post.avatar;
  document.getElementById("detailName").textContent = post.name;
  document.getElementById("detailTime").textContent = post.time;
  document.getElementById("detailContent").textContent = post.content;
  
  document.getElementById("detailCommentsCount").textContent =
    post.comments.length;

  renderComments();

  document.getElementById("postDetailPopup").classList.remove("hidden");
}

function closePostDetail() {
  document.getElementById("postDetailPopup").classList.add("hidden");
}



// HIỂN THỊ BÌNH LUẬN
function renderComments() {
  const list = document.getElementById("commentList");
  list.innerHTML = "";

  selectedPost.comments.forEach((c) => {
    const item = document.createElement("div");
    item.className = "bg-gray-100 p-3 rounded-lg";
    item.innerHTML = `<strong>${c.name}:</strong> ${c.text}`;
    list.appendChild(item);
  });
}


// THÊM BÌNH LUẬN
function addComment() {
    const text = document.getElementById("commentInput").value.trim();
    if (text === "" || !selectedPost) return;

    const form = new FormData();
    form.append("post_id", selectedPost.post_id);
    form.append("content", text);

    fetch("community.php?action=create_comment", {
        method: "POST",
        body: form
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            document.getElementById("commentInput").value = "";
            loadPosts(); // reload dữ liệu từ DB

            // cập nhật selectedPost theo dữ liệu mới
            setTimeout(() => {
                selectedPost = posts.find(p => p.post_id == selectedPost.post_id);
                renderComments();
                document.getElementById("detailCommentsCount").textContent =
                    selectedPost.comments.length;
            }, 200);

        } else {
            alert("Lỗi khi lưu bình luận!");
        }
    });
}


// ====== KHỞI TẠO — RENDER LẦN ĐẦU ======
window.onload = () => {
  loadPosts();
};

</script>


</body>
</html>
