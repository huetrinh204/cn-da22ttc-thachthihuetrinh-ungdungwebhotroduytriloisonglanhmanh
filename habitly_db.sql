-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 09:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `habitly_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `cmt_id` int(11) NOT NULL,
  `content_cmt` text NOT NULL,
  `created_cmt` datetime NOT NULL DEFAULT current_timestamp(),
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`cmt_id`, `content_cmt`, `created_cmt`, `post_id`, `user_id`) VALUES
(7, 'Chúc mừng bà nha', '2025-12-05 15:33:45', 9, 15),
(11, 'liên hệ fb: Mai Trúc(mèo) nha', '2025-12-14 15:46:30', 12, 32),
(12, 'bạn lên yt tìm Mai Tăng Cân nha, chị đó có vài tip tăng cân hay lắm', '2025-12-14 15:47:25', 11, 32);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status_fb` enum('read','unread') NOT NULL,
  `created_fb` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `reply_message` text DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedback_id`, `message`, `status_fb`, `created_fb`, `user_id`, `reply_message`, `replied_at`) VALUES
(1, 'Tôi sử dụng ứng dụng bị lag, mong nhà phát triển khắc phục lại vấn đề này', 'read', '2025-12-13 16:26:00', 15, 'Cảm ơn bạn đã phản hồi. Chúng tôi sẽ sớm giải quyết vấn đề của bạn', '2025-12-15 15:54:49'),
(2, 'Tôi không thể thêm Thói quen mới, nhờ admin xem và kiểm tra lại', 'unread', '2025-12-15 16:03:21', 32, NULL, NULL),
(3, 'Tôi xoá thói quen không được, mong admin hỗ trợ', 'read', '2025-12-15 16:12:36', 15, 'Chào bạn, hiện tại hệ thống đang bảo trì nên website bị delay, bạn hãy kiên nhẫn đợi một chút rồi reload lại trang thì sẽ được ạ!', '2025-12-15 16:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `habit`
--

CREATE TABLE `habit` (
  `habit_id` int(11) NOT NULL,
  `habit_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(10) DEFAULT NULL,
  `start_date` date NOT NULL,
  `current_streak` int(11) NOT NULL,
  `best_streak` int(11) NOT NULL,
  `status` enum('Người dùng','Mẫu') NOT NULL,
  `created_hb` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `last_completed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `habit`
--

INSERT INTO `habit` (`habit_id`, `habit_name`, `description`, `icon`, `start_date`, `current_streak`, `best_streak`, `status`, `created_hb`, `user_id`, `last_completed_date`) VALUES
(20, 'Uống nước', 'Uống 500ml nước', '💧', '0000-00-00', 1, 0, 'Mẫu', '2025-11-23 12:23:07', 17, '2025-11-30'),
(28, 'tieumytest', 'test', '🏃', '0000-00-00', 1, 0, 'Người dùng', '2025-11-28 17:20:37', 18, NULL),
(84, 'Làm bài tập', '1 tiếng', '📝', '0000-00-00', 1, 0, 'Người dùng', '2025-12-04 17:07:19', 27, '2025-12-15'),
(86, 'Thiền', 'Ngồi thiền cho tịnh tâm ', '🧘', '0000-00-00', 1, 0, 'Người dùng', '2025-12-05 17:41:53', 21, '2025-12-05'),
(87, 'Đọc sách', 'Đọc 30 phút', '📚', '0000-00-00', 2, 0, 'Người dùng', '2025-12-07 16:05:29', 15, '2025-12-16'),
(88, 'Thiền', 'Tịnh tâm 30 phút', '🧘', '0000-00-00', 2, 0, 'Người dùng', '2025-12-07 16:09:49', 15, '2025-12-16'),
(89, 'Hít đất', '50 cái', '🎯', '0000-00-00', 1, 0, 'Người dùng', '2025-12-07 19:28:32', 30, '2025-12-07'),
(90, 'Chạy xe đạp', '20 phút', '🚴', '0000-00-00', 2, 0, 'Người dùng', '2025-12-08 09:43:03', 33, '2025-12-15'),
(91, 'Chạy bộ', 'chạy 20 phút', '🏃', '0000-00-00', 1, 0, 'Người dùng', '2025-12-08 15:36:34', 32, '2025-12-15'),
(92, 'Thiền', '20 phút', '🧘', '0000-00-00', 1, 0, 'Người dùng', '2025-12-08 15:41:49', 32, '2025-12-15'),
(93, 'Nghe nhạc', 'nghe 10 phút', '🎧', '0000-00-00', 2, 0, 'Người dùng', '2025-12-08 19:52:54', 33, '2025-12-15'),
(94, 'Đọc sách', 'đọc 20 phút', '📚', '0000-00-00', 1, 0, 'Người dùng', '2025-12-08 20:22:09', 32, '2025-12-15'),
(95, 'Tập yoga', '10 phút', '🧘', '0000-00-00', 2, 0, 'Người dùng', '2025-12-08 20:34:39', 33, '2025-12-15'),
(96, 'Đọc sách', 'đọc 10 phút', '📚', '0000-00-00', 0, 0, 'Người dùng', '2025-12-09 09:57:41', 34, NULL),
(98, 'Nghe nhạc', 'nghe 10 phút', '🎧', '0000-00-00', 1, 0, 'Người dùng', '2025-12-11 18:21:23', 15, '2025-12-15'),
(99, 'Chạy bộ', 'Chạy 30 phút', '🏃', '0000-00-00', 1, 0, 'Người dùng', '2025-12-11 18:23:23', 15, '2025-12-15'),
(100, 'Nghe nhạc', 'nghe 10 phút cho thư giãn', '🎧', '0000-00-00', 1, 0, 'Người dùng', '2025-12-13 14:19:01', 32, '2025-12-15'),
(101, 'Làm bài tập', '30 phút', '📝', '0000-00-00', 1, 0, 'Người dùng', '2025-12-13 17:53:54', 32, '2025-12-15'),
(102, 'Tập yoga', '30 phút', '🧘', '0000-00-00', 1, 0, 'Người dùng', '2025-12-13 17:54:19', 32, '2025-12-15'),
(103, 'Ăn rau củ', 'Ăn 300g salad', '🥗', '0000-00-00', 1, 0, 'Người dùng', '2025-12-13 17:54:53', 32, '2025-12-15'),
(104, 'Bơi lội', 'Bơi 5 vòng', '🏊', '0000-00-00', 1, 0, 'Người dùng', '2025-12-15 17:40:06', 35, '2025-12-15'),
(105, 'Chạy bộ', 'chạy 30 phút', '🏃', '0000-00-00', 1, 0, 'Người dùng', '2025-12-15 18:50:52', 27, '2025-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `habit_logs`
--

CREATE TABLE `habit_logs` (
  `log_id` int(11) NOT NULL,
  `log_date` date NOT NULL DEFAULT current_timestamp(),
  `completed` enum('done','missed') NOT NULL,
  `habit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habit_logs`
--

INSERT INTO `habit_logs` (`log_id`, `log_date`, `completed`, `habit_id`, `user_id`) VALUES
(1, '2025-11-28', 'done', 20, 15),
(7, '2025-11-28', 'done', 20, 18),
(11, '2025-11-28', 'done', 28, 18),
(12, '2025-11-28', 'done', 20, 19),
(16, '2025-11-28', 'done', 20, 20),
(20, '2025-11-28', 'done', 20, 21),
(24, '2025-11-28', 'done', 20, 22),
(28, '2025-11-28', 'missed', 20, 23),
(32, '2025-11-28', 'done', 20, 24),
(36, '2025-11-28', 'done', 20, 25),
(43, '2025-11-30', 'done', 20, 15),
(47, '2025-11-30', 'done', 20, 24),
(51, '2025-11-30', 'missed', 20, 24),
(54, '2025-11-30', 'done', 20, 24),
(60, '2025-11-30', 'done', 20, 26),
(68, '2025-11-30', 'done', 20, 28),
(72, '2025-11-30', 'done', 20, 29),
(76, '2025-12-04', 'done', 20, 15),
(80, '2025-12-04', 'done', 20, 27),
(84, '2025-12-04', 'done', 84, 27),
(89, '2025-12-04', 'done', 20, 26),
(94, '2025-12-05', 'done', 20, 15),
(95, '2025-12-05', 'done', 84, 27),
(96, '2025-12-05', 'done', 20, 27),
(97, '2025-12-05', 'done', 20, 21),
(98, '2025-12-05', 'done', 86, 21),
(99, '2025-12-07', 'done', 20, 15),
(100, '2025-12-07', 'done', 87, 15),
(101, '2025-12-07', 'done', 88, 15),
(102, '2025-12-07', 'done', 20, 20),
(103, '2025-12-07', 'done', 20, 19),
(104, '2025-12-07', 'done', 20, 30),
(105, '2025-12-07', 'done', 89, 30),
(106, '2025-12-08', 'done', 88, 15),
(107, '2025-12-08', 'done', 87, 15),
(108, '2025-12-08', 'done', 20, 15),
(109, '2025-12-08', 'done', 20, 31),
(110, '2025-12-08', 'done', 20, 33),
(111, '2025-12-08', 'done', 90, 33),
(112, '2025-12-08', 'done', 20, 32),
(113, '2025-12-08', 'done', 91, 32),
(114, '2025-12-08', 'done', 92, 32),
(115, '2025-12-08', 'done', 84, 27),
(116, '2025-12-08', 'done', 20, 27),
(117, '2025-12-08', 'done', 93, 33),
(118, '2025-12-08', 'done', 94, 32),
(119, '2025-12-08', 'done', 95, 33),
(120, '2025-12-09', 'done', 20, 34),
(121, '2025-12-09', 'done', 20, 32),
(122, '2025-12-09', 'done', 91, 32),
(123, '2025-12-09', 'done', 92, 32),
(124, '2025-12-09', '', 94, 32),
(125, '2025-12-09', 'done', 90, 33),
(126, '2025-12-09', 'done', 20, 33),
(127, '2025-12-09', 'done', 93, 33),
(129, '2025-12-09', 'done', 95, 33),
(130, '2025-12-09', '', 87, 15),
(131, '2025-12-09', '', 88, 15),
(132, '2025-12-11', 'done', 88, 15),
(133, '2025-12-11', 'done', 87, 15),
(134, '2025-12-11', 'done', 20, 15),
(135, '2025-12-11', '', 98, 15),
(136, '2025-12-11', '', 99, 15),
(137, '2025-12-13', 'done', 91, 32),
(138, '2025-12-13', 'done', 92, 32),
(139, '2025-12-13', 'done', 94, 32),
(140, '2025-12-13', 'done', 20, 32),
(141, '2025-12-13', 'done', 100, 32),
(142, '2025-12-13', 'done', 87, 15),
(143, '2025-12-13', 'done', 99, 15),
(144, '2025-12-13', 'done', 98, 15),
(145, '2025-12-13', 'missed', 88, 15),
(146, '2025-12-13', 'done', 20, 15),
(147, '2025-12-14', 'done', 103, 32),
(148, '2025-12-14', 'missed', 102, 32),
(149, '2025-12-14', 'done', 101, 32),
(150, '2025-12-14', 'done', 91, 32),
(151, '2025-12-14', 'done', 92, 32),
(152, '2025-12-14', 'done', 94, 32),
(153, '2025-12-14', 'done', 100, 32),
(154, '2025-12-14', 'done', 90, 33),
(155, '2025-12-14', 'done', 99, 15),
(156, '2025-12-14', 'done', 95, 33),
(157, '2025-12-14', 'done', 93, 33),
(159, '2025-12-14', 'done', 20, 32),
(160, '2025-12-15', 'done', 20, 32),
(161, '2025-12-15', 'done', 91, 32),
(162, '2025-12-15', 'done', 92, 32),
(163, '2025-12-15', 'done', 94, 32),
(164, '2025-12-15', 'done', 100, 32),
(165, '2025-12-15', 'done', 101, 32),
(166, '2025-12-15', 'done', 102, 32),
(167, '2025-12-15', 'done', 103, 32),
(168, '2025-12-15', 'done', 95, 33),
(169, '2025-12-15', 'done', 93, 33),
(170, '2025-12-15', 'done', 90, 33),
(171, '2025-12-15', 'done', 20, 33),
(172, '2025-12-15', 'done', 99, 15),
(173, '2025-12-15', 'done', 98, 15),
(174, '2025-12-15', 'done', 88, 15),
(175, '2025-12-15', 'done', 20, 15),
(176, '2025-12-15', 'done', 87, 15),
(177, '2025-12-15', 'done', 20, 35),
(178, '2025-12-15', 'done', 104, 35),
(179, '2025-12-15', 'done', 20, 27),
(180, '2025-12-15', 'done', 84, 27),
(181, '2025-12-15', 'done', 105, 27),
(182, '2025-12-16', 'done', 20, 15),
(183, '2025-12-16', 'done', 87, 15),
(184, '2025-12-16', 'done', 88, 15);

-- --------------------------------------------------------

--
-- Table structure for table `health_journal`
--

CREATE TABLE `health_journal` (
  `journal_id` int(11) NOT NULL,
  `journal_date` date NOT NULL DEFAULT current_timestamp(),
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `icon` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_journal`
--

INSERT INTO `health_journal` (`journal_id`, `journal_date`, `title`, `content`, `icon`, `user_id`) VALUES
(9, '2025-12-05', 'Đi tập thể dục', 'Đi tập thể dục gặp lại người bạn cũ trò chuỵen rất vui', '😐', 15),
(11, '2025-12-04', 'Buồn bã', 'Hôm nay có buổi hẹn chạy xe đạp với bạn thân nhưng trời lại đổ mưa ', '😢', 15),
(12, '2025-12-04', 'Bất lực', 'Sửa hoài không xong cái web', '😐', 27),
(13, '2025-12-07', 'Niềm vui ở mọi nơi', 'Hôm nay cảm thấy vui vẻ chả vì điều gì cả đơn giản chỉ là cảm giác vui vẻ yêu đời và hạnh phúc thôi', '😊', 15),
(14, '2025-12-07', 'Thành công tăng 2kg', 'Nhờ tập vài bài tập hít đất và ăn uống healthy mà nay đã tăng được 2kg, trông đẹp trai hơn hẳn hehe', '💪', 30),
(16, '2025-12-08', 'Uể oải', 'web của mình còn tệ quá, cảm thấy không hài lòng ', '😢', 32),
(17, '2025-12-08', 'Đau lưng', 'Ngồi nhẹ vài tiếng để fix bug cảm thấy thật yomost quá đi thôi', '😄', 33),
(19, '2025-12-13', 'Tích cực', 'Hôm nay cảm thấy tích cực lạ thường', '😄', 32),
(20, '2025-12-14', 'Buồn ngủ', 'Hôm nay ngủ không đủ giấc gì cả, cảm thấy buồn ngủ, nhưng không thể ngủ vì bài chưa làm xong huhu', '😢', 32);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `noti_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`noti_id`, `content`, `sent_at`, `user_id`) VALUES
(1, 'c đã bình luận vào bài của bạn.', '2025-12-05 15:19:54', 27),
(2, 'c đã bình luận vào bài của bạn.', '2025-12-05 15:20:26', 27),
(5, 'meocute đã đăng một bài mới.', '2025-12-05 15:33:34', 20),
(7, 'meocute đã đăng một bài mới.', '2025-12-05 15:33:34', 17),
(8, 'meocute đã đăng một bài mới.', '2025-12-05 15:33:34', 27),
(13, 'meocute đã đăng một bài mới.', '2025-12-05 15:33:34', 19),
(15, 'meocute đã đăng một bài mới.', '2025-12-05 15:33:34', 21),
(17, 'meocute đã đăng một bài mới.', '2025-12-05 15:33:34', 18),
(19, 'd đã đăng một bài mới.', '2025-12-05 17:14:31', 20),
(20, 'd đã đăng một bài mới.', '2025-12-05 17:14:31', 17),
(21, 'd đã đăng một bài mới.', '2025-12-05 17:14:31', 19),
(22, 'd đã đăng một bài mới.', '2025-12-05 17:14:31', 15),
(23, 'd đã đăng một bài mới.', '2025-12-05 17:14:31', 21),
(25, 'd đã đăng một bài mới.', '2025-12-05 17:14:31', 18),
(27, 'meocute đã đăng một bài mới.', '2025-12-07 16:07:30', 20),
(28, 'meocute đã đăng một bài mới.', '2025-12-07 16:07:30', 17),
(29, 'meocute đã đăng một bài mới.', '2025-12-07 16:07:30', 27),
(30, 'meocute đã đăng một bài mới.', '2025-12-07 16:07:30', 19),
(31, 'meocute đã đăng một bài mới.', '2025-12-07 16:07:30', 21),
(33, 'meocute đã đăng một bài mới.', '2025-12-07 16:07:30', 18),
(35, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 20),
(36, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 17),
(37, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 27),
(38, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 19),
(39, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 15),
(40, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 21),
(42, 'Minh Khôi đã đăng một bài mới.', '2025-12-07 19:29:52', 18),
(44, 'Minh Khôi đã bình luận vào bài của bạn.', '2025-12-07 19:32:10', 15),
(45, 'Meo Meo đã bình luận vào bài của bạn.', '2025-12-09 10:49:47', 30),
(46, 'Huệ Trinh đã bình luận vào bài của bạn.', '2025-12-14 15:46:30', 30),
(47, 'Huệ Trinh đã bình luận vào bài của bạn.', '2025-12-14 15:47:25', 15),
(48, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 20),
(49, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 17),
(50, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 27),
(51, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 19),
(52, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 15),
(53, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 21),
(54, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 30),
(56, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 18),
(58, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 33),
(59, 'Huệ Trinh đã đăng một bài mới.', '2025-12-14 15:49:49', 34);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `content`, `created_at`, `user_id`) VALUES
(9, 'Hôm nay tôi đã tăng lên được 5kg, quá là vui', '2025-12-05 15:33:34', 15),
(11, 'Mọi người chia sẻ cho mình vài bài tập tăng cân với, mình gầy quá huhu!', '2025-12-07 16:07:30', 15),
(12, 'Ai đó chia sẻ giúp mình vài bài tập cơ bụng được không mọi người ơi!', '2025-12-07 19:29:52', 30),
(13, 'Mọi người ơi mình mới tăng được 5kg, vui quá trời!!', '2025-12-14 15:49:49', 32);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Nam','Nữ','Khác') NOT NULL,
  `tel` varchar(10) NOT NULL,
  `health_goal` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `create_acc` datetime NOT NULL DEFAULT current_timestamp(),
  `last_activity` datetime NOT NULL DEFAULT current_timestamp(),
  `total_streak` int(11) NOT NULL DEFAULT 0,
  `last_streak_update` date DEFAULT NULL,
  `is_blocked` tinyint(1) DEFAULT 0,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `gender`, `tel`, `health_goal`, `role`, `create_acc`, `last_activity`, `total_streak`, `last_streak_update`, `is_blocked`, `google_id`, `avatar`) VALUES
(15, 'meocute', 'meocute@gmail.com', '$2y$10$.nhUZctjHjrWPua0ENj.eOMf/G19IGZjg6cMqsOhKGY1bmVx3L.hi', 'Nam', '0969953014', 'Tăng lên 45kg', 'user', '2025-11-17 17:12:03', '2025-12-16 15:57:02', 8, '2025-12-15', 0, NULL, NULL),
(17, 'admin', 'admin@gmail.com', '$2y$10$eSv7qRb9J4Yq3JvcfIzvr.Vir2OrrVhJ6637EIdyxgLVE.PaSXXVe', 'Nữ', '0969953014', NULL, 'admin', '2025-11-20 16:49:59', '2025-12-15 16:41:34', 0, NULL, 0, NULL, NULL),
(18, 'tieumy', 'tieumy@gmail.com', '$2y$10$LVVSPIi2ajStDvJtxa/F8.C5wy1/M9mzLRM9A13Ko/yWFspFeMbmK', 'Nữ', '0969953014', NULL, 'user', '2025-11-28 17:19:56', '2025-11-28 17:52:14', 0, NULL, 0, NULL, NULL),
(19, 'habit', 'habit@gmail.com', '$2y$10$.30FJm.6KRqmrJ4hRIvojOejVdXucwe27UUeVyAfWdv0DktA.1CFe', 'Nữ', '0969953014', NULL, 'user', '2025-11-28 17:58:42', '2025-12-07 16:14:49', 1, '2025-12-07', 0, NULL, NULL),
(20, 'baby', 'baby@gmail.com', '$2y$10$DXgmQRKH59XE.0hExqVh/.tljL05oLatmbzBQ/z4bTcnxPzcC8OrS', 'Nữ', '0969953014', NULL, 'user', '2025-11-28 18:03:14', '2025-12-07 16:13:36', 1, '2025-12-07', 0, NULL, NULL),
(21, 'My', 'my@gmail.com', '$2y$10$KNaqtH/VVtumTSpQnwEUieGexufFWX5mPDD2wAimd.JbuEVl/x196', 'Nữ', '0969953014', NULL, 'user', '2025-11-28 18:08:33', '2025-12-05 17:36:52', 1, '2025-12-05', 1, NULL, NULL),
(27, 'Dũng', 'dung@gmail.com', '$2y$10$VeoNQzWjaqzp21yDHG/Kh.5QfXS0XnOt5BiSEtvZuethjnr0GfhDq', 'Nữ', '0969953014', 'Body 6 múi', 'user', '2025-11-30 18:49:47', '2025-12-15 18:47:01', 4, '2025-12-15', 1, NULL, NULL),
(30, 'Minh Khôii', 'minhkhoi@gmail.com', '$2y$10$kj3wqrMYqDSIjesrw/st/umpXxlHjc93/9QIJ.emCA4gFoUvf.JFe', 'Nam', '0969953014', NULL, 'user', '2025-12-07 19:27:37', '2025-12-07 19:27:49', 1, '2025-12-07', 0, NULL, NULL),
(32, 'Huệ Trinh', 'trinhfokko@gmail.com', '', 'Nữ', '0969953014', 'Tăng cân 45kg', 'user', '2025-12-08 09:36:33', '2025-12-08 09:36:33', 4, '2025-12-15', 0, '118303168284513596073', 'https://lh3.googleusercontent.com/a/ACg8ocK14TDDO8-mpvettsDJcSuXQSFPHsn7Y2kQ4XynV02WpH5RQbar=s96-c'),
(33, 'Meo Meo', 'trinhmeo2k4@gmail.com', '', 'Nam', '', 'Tăng 10kg', 'user', '2025-12-08 09:42:33', '2025-12-08 09:42:33', 3, '2025-12-15', 0, '118208282136441304391', 'https://lh3.googleusercontent.com/a/ACg8ocJHfoPdQQ9uJ6mrR96T0gqQHYM6LBPykhnQY4BivUqW81UVo0k=s96-c'),
(34, 'Minh Mẫn', 'truongle2472004@gmail.com', '$2y$10$Uj7b8l719PqLb97VO0ZAtum.LBZky3V5KDMI1iwbfLco9qfJ3Hq02', 'Nam', '0969953014', NULL, 'user', '2025-12-09 09:57:04', '2025-12-09 10:21:52', 0, NULL, 1, NULL, NULL),
(35, 'Gia Bảo', 'bao@gmail.com', '$2y$10$FDAPRjmf2J/35HLjkJGOTupW6NrQ5.f5MBU8paiXqKJl8BYrqE23y', 'Nam', '0969953014', 'Cao 1m80', 'user', '2025-12-15 17:39:20', '2025-12-15 17:39:29', 1, '2025-12-15', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cmt_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `habit`
--
ALTER TABLE `habit`
  ADD PRIMARY KEY (`habit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `habit_logs`
--
ALTER TABLE `habit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `habit_id` (`habit_id`);

--
-- Indexes for table `health_journal`
--
ALTER TABLE `health_journal`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`noti_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `cmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `habit`
--
ALTER TABLE `habit`
  MODIFY `habit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `habit_logs`
--
ALTER TABLE `habit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `health_journal`
--
ALTER TABLE `health_journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `habit`
--
ALTER TABLE `habit`
  ADD CONSTRAINT `habit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `habit_logs`
--
ALTER TABLE `habit_logs`
  ADD CONSTRAINT `habit_logs_ibfk_1` FOREIGN KEY (`habit_id`) REFERENCES `habit` (`habit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `health_journal`
--
ALTER TABLE `health_journal`
  ADD CONSTRAINT `health_journal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
