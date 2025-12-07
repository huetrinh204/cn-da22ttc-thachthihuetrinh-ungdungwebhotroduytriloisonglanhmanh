<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<nav class="flex justify-between px-8 py-3 items-center bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-lg">
    <div class="flex items-center gap-3">
        <img style="border-radius: 60%" src="assets/images/logo_habitu.png" width="38">
        <h2 class="text-xl font-bold">Habitu <span class="bg-yellow-400 text-black px-2 py-0.5 rounded text-sm ml-2">ADMIN</span></h2>
    </div>

    <ul class="flex gap-8 font-medium">
        <li class="flex items-center gap-1">
            <i class="fas fa-tachometer-alt"></i>
            <a href="index.php" class="hover:text-yellow-300 transition">Dashboard</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-user"></i>
            <a href="users.php" class="hover:text-yellow-300 transition">Người Dùng</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-file-alt"></i>
            <a href="post.php" class="hover:text-yellow-300 transition">Bài Viết</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-redo"></i>
            <a href="habits.php" class="hover:text-yellow-300 transition">Thói Quen</a>
        </li>
        <li class="flex items-center gap-1">
            <i class="fas fa-cog"></i>
            <a href="settings.php" class="hover:text-yellow-300 transition">Cài Đặt</a>
        </li>
    </ul>

 <div class="relative flex items-center gap-2">
    <span id="adminDropdownBtn" class="flex items-center gap-1 cursor-pointer select-none text-white">
        <i class="fas fa-user-circle text-xl"></i>
         <span><?php echo htmlspecialchars($username); ?></span>
        <i class="fas fa-chevron-down text-sm"></i>
    </span>

    <!-- Dropdown -->
    <div id="adminDropdown" class="absolute top-full mt-1 left-0 w-44 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg shadow-lg hidden z-50">
       
        <a href="../home.html" class="flex items-center gap-2 px-4 py-2 hover:opacity-80 rounded-b-lg">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</div>

<script>
  const btn = document.getElementById('adminDropdownBtn');
  const dropdown = document.getElementById('adminDropdown');

  btn.addEventListener('click', () => {
    dropdown.classList.toggle('hidden');
  });

  window.addEventListener('click', (e) => {
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
    }
  });
</script>

</nav>
