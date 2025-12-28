<div align="center">

# 🐱 Habitu
### *Ứng dụng web hỗ trợ duy trì lối sống lành mạnh*

![Habitu Banner](./assets/images/welcome.png)

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://javascript.com)

*"Một thói quen nhỏ hôm nay, một cuộc sống lành mạnh ngày mai!"* 🌱✨

</div>

---

## 🌟 Giới thiệu

**Habitu** là một ứng dụng web dễ thương và trực quan, được thiết kế để giúp bạn xây dựng, theo dõi và duy trì thói quen lành mạnh mỗi ngày. Với giao diện thân thiện và các tính năng thông minh, Habitu sẽ đồng hành cùng bạn trong hành trình tự hoàn thiện bản thân! 🐾

### 🎯 Tại sao chọn Habitu?

- 🎨 **Giao diện dễ thương**: Thiết kế với màu sắc tươi sáng, icon cute và animation mượt mà
- 📱 **Responsive Design**: Hoạt động mượt mà trên mọi thiết bị
- 🔒 **Bảo mật cao**: Mã hóa mật khẩu và quản lý session an toàn
- 🌐 **Cộng đồng**: Kết nối và chia sẻ với những người cùng chí hướng

---

## ✨ Tính năng chính

<table>
<tr>
<td width="50%">

### 🎯 Quản lý thói quen
- Tạo thói quen cá nhân hoặc chọn từ thư viện mẫu
- Theo dõi streak (chuỗi ngày) hoàn thành
- Đánh dấu hoàn thành dễ dàng
- Thống kê tiến độ chi tiết

### 📔 Nhật ký cảm xúc
- Ghi lại tâm trạng hàng ngày
- Thêm tag và ghi chú cá nhân
- Theo dõi sự thay đổi tích cực

</td>
<td width="50%">

### 🌐 Cộng đồng
- Chia sẻ thói quen với bạn bè
- Động viên và hỗ trợ lẫn nhau
- Xem tiến độ của cộng đồng

### 📊 Thống kê & Báo cáo
- Biểu đồ tiến độ trực quan
- Phân tích xu hướng cá nhân
- Báo cáo định kỳ

</td>
</tr>
</table>

---

## 🛠️ Công nghệ sử dụng

<div align="center">

| **Frontend** | **Backend** | **Database** | **Tools** |
|:---:|:---:|:---:|:---:|
| HTML5 | PHP 8+ | MySQL 8.0+ | Chart.js |
| CSS3 | Session Management | UTF8MB4 | Font Awesome |
| JavaScript ES6+ | PDO | Prepared Statements | TailwindCSS |
| TailwindCSS | Password Hashing | Foreign Keys | Google OAuth |

</div>

---

## 📁 Cấu trúc dự án

```
habitu/
├── 📁 assets/                 # Tài nguyên tĩnh
│   ├── 🎨 css/               # Stylesheets
│   ├── ⚡ js/                # JavaScript files
│   ├── 🖼️ images/            # Hình ảnh
│   └── 🎯 icons/             # Icon set
├── 📁 admin/                 # Quản trị hệ thống
│   ├── 👥 users.php          # Quản lý người dùng
│   ├── 🎯 habits.php         # Quản lý thói quen
│   └── 📊 feedbacks.php      # Phản hồi người dùng
├── 📁 progress-report/       # Báo cáo tiến độ
├── 🏠 index.php             # Trang chủ & onboarding
├── 📊 dashboard.php         # Bảng điều khiển chính
├── 🔐 dangnhap.php          # Đăng nhập
├── � dangky.php            # Đăng ký
├── 📔 journal.php           # Nhật ký cảm xúc
├── 🌐 community.php         # Cộng đồng
├── ⚙️ config.php            # Cấu hình database
└── 📄 habitly_db.sql        # Database schema
```

---

## 🚀 Hướng dẫn cài đặt

### Yêu cầu hệ thống
- PHP 8.0 trở lên
- MySQL 8.0 trở lên
- Web server (Apache/Nginx)
- Composer (tùy chọn)

### Các bước cài đặt

1. **📥 Clone repository**
   ```bash
   git clone https://github.com/your-username/habitu.git
   cd habitu
   ```

2. **🗄️ Thiết lập database**
   ```sql
   CREATE DATABASE habitly_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
   Import file `habitly_db.sql` vào database

3. **⚙️ Cấu hình kết nối**
   Chỉnh sửa file `config.php`:
   ```php
   $host = "localhost";
   $dbname = "habitly_db";
   $user = "your_username";
   $pass = "your_password";
   ```

4. **🌐 Cấu hình Google OAuth** (tùy chọn)
   Chỉnh sửa `config_google.php` với thông tin OAuth của bạn

5. **📧 Cấu hình email** (tùy chọn)
   Thiết lập SMTP trong `config_mail.php`

6. **🚀 Khởi chạy**
   Truy cập `http://localhost/habitu` trên trình duyệt

---

## 📱 Screenshots

<div align="center">

| Onboarding | Dashboard | Community |
|:---:|:---:|:---:|
| ![Onboarding](./assets/cat_fun.png) | ![Dashboard](./assets/cat_ok.png) | ![Community](./assets/cat_sad.png) |

</div>

---

## 🎨 Đặc điểm giao diện

- 🎭 **Mascot dễ thương**: Chú mèo Habitu đồng hành trong mọi hành trình
- 🌈 **Màu sắc tươi sáng**: Palette màu tích cực, tạo cảm giác vui vẻ
- ✨ **Animation mượt mà**: Hiệu ứng chuyển tiếp và hover đẹp mắt
- 📱 **Mobile-first**: Thiết kế ưu tiên trải nghiệm mobile
- 🔍 **UX thân thiện**: Luồng sử dụng đơn giản, trực quan

---

## 🔮 Roadmap tương lai

### Version 2.0
- [ ] 🤖 AI Chatbot tư vấn thói quen
- [ ] 📱 Progressive Web App (PWA)
- [ ] 🔔 Push notifications
- [ ] 📈 Advanced analytics với ML

### Version 2.5
- [ ] 🌐 Tích hợp mạng xã hội
- [ ] 🏆 Hệ thống gamification
- [ ] 📊 Dashboard admin nâng cao
- [ ] 🌍 Đa ngôn ngữ

---

## 🤝 Đóng góp

Chúng tôi rất hoan nghênh mọi đóng góp! Hãy:

1. 🍴 Fork repository
2. 🌿 Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. 💾 Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. 📤 Push to branch (`git push origin feature/AmazingFeature`)
5. 🔄 Tạo Pull Request

---

## 📄 License

Dự án này được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

---

## 📞 Liên hệ & Hỗ trợ

<div align="center">

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/huetrinh204)
[![Email](https://img.shields.io/badge/Email-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:trinhfokko@gmail.com)

**Cần hỗ trợ?** Tạo issue trên GitHub hoặc gửi email cho chúng tôi!

</div>

---

<div align="center">

### 🐾 Cảm ơn bạn đã sử dụng Habitu!

*Hãy để Habitu đồng hành cùng bạn trong hành trình xây dựng thói quen lành mạnh* 💛

**Made with 💖 by Huệ Trinh**

</div>
