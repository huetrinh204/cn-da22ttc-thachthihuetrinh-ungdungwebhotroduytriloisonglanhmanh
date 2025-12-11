<?php
require "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Khởi tạo biến lưu giá trị input
$username = $email = $password = $confirm = $gender = $tel = "";
$popup = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirm = $_POST["confirm_password"];
  $gender = $_POST["gender"];
  $tel = $_POST["tel"];

  // Kiểm tra mật khẩu >=6 ký tự
  if (strlen($password) < 6) {
    $popup = "Mật khẩu phải có ít nhất 6 ký tự!";
  }
  // Kiểm tra mật khẩu khớp
  elseif ($password !== $confirm) {
    $popup = "Mật khẩu xác nhận không khớp!";
  } else {
    try {
      // Kiểm tra email đã tồn tại chưa
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
      $stmt->execute([":email" => $email]);
      if ($stmt->fetch()) {
        $popup = "Email đã tồn tại!";
      } else {
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, gender, tel, role, create_acc)
                        VALUES (:username, :email, :password, :gender, :tel, 'user', NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
          ":username" => $username,
          ":email" => $email,
          ":password" => $hashedPassword,
          ":gender" => $gender,
          ":tel" => $tel
        ]);

        $popup = "Đăng ký thành công!";
        $success = true; // đánh dấu thành công
      }
    } catch (PDOException $e) {
      $popup = "Lỗi đăng ký: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Ký</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    html,
    body {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to right, #00c6ff, #0072ff);
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header img {
      display: block;
      margin: 0 auto 10px;
    }

    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      width: 360px;
      max-width: 90%;
      padding: 40px 30px;
      margin: 40px auto;
    }

    h2 {
      margin: 10px 0 5px;
      color: #00bfff;
    }

    p {
      font-size: 20px;
      color: #666;
      margin-bottom: 20px;
    }

    form {
      text-align: left;
    }

    label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      font-size: 14px;
    }

    .checkbox {
      font-size: 12px;
      color: #555;
      display: flex;
      align-items: center;
      gap: 5px;
      margin-bottom: 15px;
    }

    .checkbox a {
      color: #00bfff;
      text-decoration: none;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: #00bfff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
      margin-bottom: 15px;
    }

    .btn:hover {
      background-color: #0099cc;
    }

    .signup-link {
      font-size: 13px;
      color: #666;
      text-align: center;
    }

    .signup-link a {
      color: #00bfff;
      text-decoration: none;
      font-weight: 600;
    }

    /* popup */
    #popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    #popup .box {
      background: white;
      padding: 20px 30px;
      border-radius: 8px;
      text-align: center;
      max-width: 300px;
      position: relative;
    }

    #popup .box button.close {
      position: absolute;
      top: 5px;
      right: 8px;
      border: none;
      background: none;
      font-size: 18px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="logo"><img src="assets/logo_habitu.png" width="120" height="120" alt="Habitu Logo" class="logo-img"
        style="display:block; margin:0 auto;">
      <div class="header">
        <h2>Đăng Ký</h2>
        <p>Bắt đầu hành trình xây dựng thói quen lành mạnh! 🌼</p>
      </div>

      <form action="" method="POST">
        <label for="username">Tên đăng nhập</label>
        <input id="username" type="text" name="username" placeholder="Nhập tên của bạn" required
          value="<?= htmlspecialchars($username) ?>">

        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="your@email.com" required
          value="<?= htmlspecialchars($email) ?>">

        <label for="password">Mật khẩu</label>
        <input id="password" type="password" name="password" placeholder="Ít nhất 6 ký tự" required>

        <label for="confirm_password">Xác nhận mật khẩu</label>
        <input id="confirm_password" type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>

        <label>Giới tính</label>
        <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 16px;">
          <label><input type="radio" name="gender" value="Nam" <?= ($gender == "Nam") ? "checked" : "" ?> required> Nam</label>
          <label><input type="radio" name="gender" value="Nữ" <?= ($gender == "Nữ") ? "checked" : "" ?> required> Nữ</label>
          <label><input type="radio" name="gender" value="Khác" <?= ($gender == "Khác") ? "checked" : "" ?> required>
            Khác</label>
        </div>

        <label for="tel">Số điện thoại</label>
        <input id="tel" type="tel" name="tel" pattern="[0-9]{10}" placeholder="0123456789" required
          value="<?= htmlspecialchars($tel) ?>">

        <label class="checkbox">
          <input type="checkbox" name="agree" required>
          Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a>
        </label>

        <button type="submit" class="btn">Tạo Tài Khoản</button>
      </form>

      <p class="signup-link">Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p>
    </div>

    <!-- popup -->
    <div id="popup">
      <div class="box">
        <button class="close" onclick="document.getElementById('popup').style.display='none'">&times;</button>
        <p id="popupText"></p>
      </div>
    </div>

    <style>
      /* popup nền mờ toàn trang */
      #popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
        z-index: 9999;
        animation: fadeIn 0.3s;
      }

      #popup .box {
        background: #ffffff;
        padding: 25px 35px;
        border-radius: 12px;
        text-align: center;
        max-width: 350px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        font-family: 'Inter', sans-serif;
        color: #0072ff;
        /* chữ xanh giống nền */
        font-size: 16px;
        position: relative;
        animation: slideDown 0.3s;
      }

      #popup .box button.close {
        position: absolute;
        top: 10px;
        right: 12px;
        border: none;
        background: none;
        font-size: 20px;
        cursor: pointer;
        color: #0072ff;
        transition: transform 0.2s, color 0.2s;
      }

      #popup .box button.close:hover {
        color: #004c99;
        transform: scale(1.2);
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }

        to {
          opacity: 1;
        }
      }

      @keyframes slideDown {
        from {
          transform: translateY(-20px);
          opacity: 0;
        }

        to {
          transform: translateY(0);
          opacity: 1;
        }
      }
    </style>



    <script>
      <?php if (!empty($popup)): ?>
        const popup = document.getElementById('popup');
        const popupText = document.getElementById('popupText');
        popupText.innerText = "<?= $popup ?>";
        popup.style.display = "flex";
        <?php if (isset($success) && $success): ?>
          setTimeout(function () { window.location.href = 'dangnhap.php'; }, 1000);
        <?php endif; ?>
      <?php endif; ?>
    </script>
</body>

</html>