<?php
session_start();
include "config.php";  // sử dụng $pdo

// Lấy user
$user_id = $_SESSION["user_id"] ?? null;
$username = $_SESSION["username"] ?? null;

?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cộng Đồng</title>
<link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-cyan-300 to-teal-400 min-h-screen">

<?php include "navbar.php"; ?>

<section class="container mx-auto mt-10 px-4">
<div class="bg-white/90 p-8 rounded-3xl shadow-xl max-w-4xl mx-auto">

    <h2 class="text-xl font-semibold text-teal-700 mb-3">
        Cộng Đồng Thói Quen
    </h2>

    <!-- TIÊU ĐỀ -->
    <input id="createPostTitle"
        type="text"
        placeholder="Nhập tiêu đề bài viết..."
        class="w-full border border-teal-300 rounded-xl p-3 mb-3 bg-gray-50">

    <!-- NỘI DUNG -->
    <textarea id="createPostInput"
      placeholder="Chia sẻ câu chuyện của bạn..."
      class="w-full h-32 border border-teal-300
             rounded-xl p-3 bg-gray-50"></textarea>

    <button onclick="submitPost()"
      class="mt-3 px-4 py-2 bg-teal-500 hover:bg-teal-600
             text-white rounded-md">
        Đăng Bài
    </button>

    <hr class="my-6">

    <!-- DANH SÁCH BÀI ĐĂNG -->
    <div id="postContainer"></div>

</div>
</section>


<!-- ============================================
            POPUP DETAIL BÀI VIẾT
============================================ -->
<div id="postDetailPopup"
     class="fixed inset-0 bg-black/40 hidden justify-center
            items-center p-4 z-50">
  <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6">

    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold">Chi tiết bài viết</h3>
      <button onclick="closePostDetail()" class="text-gray-700 text-2xl">×</button>
    </div>

    <h3 id="detailTitle" class="text-lg font-bold text-teal-700 mb-1"></h3>

    <h4 id="detailName" class="font-semibold"></h4>
    <p id="detailTime" class="text-gray-500 text-sm mb-3"></p>

    <p id="detailContent" class="mb-4"></p>
    <p><strong>Số bình luận:</strong>
        <span id="detailCommentsCount"></span></p>

    <div id="commentList" class="max-h-56 overflow-y-auto space-y-3 mt-3"></div>

    <textarea id="commentInput"
        class="w-full border p-3 rounded-lg mt-4"
        placeholder="Viết bình luận..."></textarea>

    <button onclick="addComment()"
        class="mt-2 px-4 py-2 bg-teal-500 text-white rounded-md">
        Gửi bình luận
    </button>

  </div>
</div>


<?php include "footer.php"; ?>


<script>
let posts = [];
let selectedPost = null;

/* =========================================================
                    LOAD BÀI VIẾT
========================================================= */
function loadPosts() {
    fetch("community_api.php?action=get_posts")
        .then(res => res.json())
        .then(data => {
            posts = data.map(p => ({
                post_id: p.post_id,
                title: p.title,
                name: p.username,
                time: p.created_at,
                content: p.content,
                comments: p.comments.map(c => ({
                    name: c.username,
                    text: c.content_cmt
                }))
            }));
            renderPostList();
        });
}


/* Render danh sách bài viết */
function renderPostList() {
    const box = document.getElementById("postContainer");
    box.innerHTML = "";

    posts.forEach(p => {
        const div = document.createElement("div");
        div.className = "bg-white rounded-2xl shadow p-5 mb-4 cursor-pointer";
        div.onclick = () => openPostDetail(p);

        div.innerHTML = `
            <h3 class="text-lg font-bold text-teal-700">${p.title}</h3>
            <h4 class="font-semibold">${p.name}</h4>
            <p class="text-gray-500 text-sm">${p.time}</p>
            <p class="mt-3">${p.content}</p>
            <p class="mt-3 text-gray-600">
                <i class="fa-regular fa-comment"></i>
                ${p.comments.length} bình luận
            </p>
        `;
        box.appendChild(div);
    });
}


/* =========================================================
                    ĐĂNG BÀI
========================================================= */
function submitPost() {
    const title = document.getElementById("createPostTitle").value.trim();
    const text  = document.getElementById("createPostInput").value.trim();

    if (!title || !text) {
        alert("Vui lòng nhập đầy đủ tiêu đề và nội dung!");
        return;
    }

    const form = new FormData();
    form.append("title", title);
    form.append("content", text);

    fetch("community_api.php?action=create_post", {
        method: "POST",
        body: form
    })
    .then(r => r.json())
    .then(d => {
        if (d.status === "success") {

            document.getElementById("createPostTitle").value = "";
            document.getElementById("createPostInput").value = "";

            // Load lại bài viết mới nhất
            loadPosts();
        }
    });
}


/* =========================================================
                    POPUP DETAIL
========================================================= */
function openPostDetail(post) {
    selectedPost = post;

    document.getElementById("detailTitle").textContent = post.title;
    document.getElementById("detailName").textContent  = post.name;
    document.getElementById("detailTime").textContent  = post.time;
    document.getElementById("detailContent").textContent = post.content;
    document.getElementById("detailCommentsCount").textContent = post.comments.length;

    renderComments();

    document.getElementById("postDetailPopup").classList.remove("hidden");
}

function closePostDetail() {
    document.getElementById("postDetailPopup").classList.add("hidden");
}

function renderComments() {
    const box = document.getElementById("commentList");
    box.innerHTML = "";

    selectedPost.comments.forEach(c => {
        const div = document.createElement("div");
        div.className = "bg-gray-100 p-3 rounded-lg";
        div.innerHTML = `<strong>${c.name}:</strong> ${c.text}`;
        box.appendChild(div);
    });
}


/* =========================================================
                    GỬI COMMENT
========================================================= */
function addComment() {
    const text = document.getElementById("commentInput").value.trim();
    if (!selectedPost || text === "") return;

    const form = new FormData();
    form.append("post_id", selectedPost.post_id);
    form.append("content", text);

    fetch("community_api.php?action=create_comment", {
        method: "POST",
        body: form
    })
    .then(r => r.json())
    .then(d => {
        if (d.status === "success") {
            document.getElementById("commentInput").value = "";
            loadPosts();   // reload comment mới
        }
    });
}

window.onload = loadPosts;
</script>

</body>
</html>
