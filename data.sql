-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 11:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram_clone`
--

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 2, 'Looks amazing!', '2025-07-21'),
(2, 1, 3, 'Wish I was there.', '2025-07-21'),
(3, 1, 4, 'Nice vibes!', '2025-07-21'),
(4, 2, 1, 'Yummy!', '2025-07-22'),
(5, 2, 3, 'Recipe please?', '2025-07-22'),
(6, 2, 5, 'Looks delicious!', '2025-07-22'),
(7, 3, 4, 'Great book!', '2025-07-23'),
(8, 3, 5, 'I love productivity tips.', '2025-07-23'),
(9, 3, 6, 'Thanks for sharing.', '2025-07-23'),
(10, 4, 7, 'Awesome hike!', '2025-07-23'),
(11, 4, 8, 'Where is this?', '2025-07-23'),
(12, 4, 1, 'Want to join next time.', '2025-07-24'),
(13, 5, 2, 'Coffee time!', '2025-07-24'),
(14, 5, 3, 'I need a cup now.', '2025-07-24'),
(15, 5, 4, 'Best way to start the day.', '2025-07-24'),
(16, 6, 5, 'Beautiful art.', '2025-07-25'),
(17, 6, 6, 'Great job!', '2025-07-25'),
(18, 6, 7, 'So talented!', '2025-07-25'),
(19, 7, 8, 'Sunsets rock.', '2025-07-25'),
(20, 7, 9, 'Beautiful colors.', '2025-07-25'),
(21, 7, 10, 'I want to go there.', '2025-07-25'),
(22, 8, 1, 'Weekend plans?', '2025-07-26'),
(23, 8, 2, 'Have fun!', '2025-07-26'),
(24, 8, 3, 'Enjoy!', '2025-07-26'),
(25, 9, 4, 'Recipe looks great.', '2025-07-26'),
(26, 9, 5, 'Yummy food.', '2025-07-26'),
(27, 9, 6, 'Can’t wait to try it.', '2025-07-26'),
(28, 10, 7, 'City lights!', '2025-07-27'),
(29, 10, 8, 'Amazing shot.', '2025-07-27'),
(30, 10, 9, 'Love the night.', '2025-07-27'),
(31, 11, 1, 'Workout done!', '2025-07-27'),
(32, 11, 2, 'Keep it up.', '2025-07-27'),
(33, 11, 3, 'Inspiring.', '2025-07-27'),
(34, 12, 4, 'Nature walk looks peaceful.', '2025-07-28'),
(35, 12, 5, 'Beautiful.', '2025-07-28'),
(36, 12, 6, 'Fresh air.', '2025-07-28'),
(37, 13, 7, 'New gadget hype!', '2025-07-28'),
(38, 13, 8, 'Cool tech.', '2025-07-28'),
(39, 13, 9, 'Want one too.', '2025-07-28'),
(40, 14, 10, 'Garden looks amazing.', '2025-07-29'),
(41, 14, 1, 'So green!', '2025-07-29'),
(42, 14, 2, 'Love flowers.', '2025-07-29'),
(43, 15, 3, 'Late night coding.', '2025-07-29'),
(44, 15, 4, 'Been there.', '2025-07-29'),
(45, 15, 5, 'Keep coding.', '2025-07-29'),
(46, 16, 6, 'Bread looks tasty.', '2025-07-30'),
(47, 16, 7, 'I want some.', '2025-07-30'),
(48, 16, 8, 'Yum!', '2025-07-30'),
(49, 17, 9, 'Friends are the best.', '2025-07-30'),
(50, 17, 10, 'Great company.', '2025-07-30'),
(51, 17, 1, 'Enjoy!', '2025-07-30'),
(52, 18, 2, 'Meditation helps.', '2025-07-31'),
(53, 18, 3, 'So calm.', '2025-07-31'),
(54, 18, 4, 'Need to try it.', '2025-07-31'),
(55, 19, 5, 'Guitar practice!', '2025-07-31'),
(56, 19, 6, 'Nice!', '2025-07-31'),
(57, 19, 7, 'Keep practicing.', '2025-07-31'),
(58, 20, 8, 'Stars are beautiful.', '2025-07-31'),
(59, 20, 9, 'Love the sky.', '2025-07-31'),
(60, 20, 10, 'Magical night.', '2025-07-31');

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `followed_by`, `followed_to`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 2, 3),
(5, 2, 5),
(6, 3, 1),
(7, 3, 4),
(8, 4, 5),
(9, 4, 6),
(10, 5, 6),
(11, 5, 7),
(12, 6, 7),
(13, 6, 8),
(14, 7, 8),
(15, 7, 9),
(16, 8, 9),
(17, 8, 10),
(18, 9, 10),
(19, 9, 1),
(20, 10, 1),
(21, 10, 2),
(22, 2, 6),
(23, 3, 7),
(24, 4, 8),
(25, 5, 9),
(26, 6, 10),
(27, 7, 1),
(28, 8, 2),
(29, 9, 3),
(30, 10, 4);

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 3),
(8, 8, 3),
(9, 9, 3),
(10, 10, 4),
(11, 1, 4),
(12, 2, 5),
(13, 3, 5),
(14, 4, 6),
(15, 5, 6),
(16, 6, 7),
(17, 7, 7),
(18, 8, 8),
(19, 9, 8),
(20, 10, 9),
(21, 1, 9),
(22, 2, 10),
(23, 3, 10),
(24, 4, 11),
(25, 5, 11),
(26, 6, 12),
(27, 7, 12),
(28, 8, 13),
(29, 9, 13),
(30, 10, 14),
(31, 1, 14),
(32, 2, 15),
(33, 3, 15),
(34, 4, 16),
(35, 5, 16),
(36, 6, 17),
(37, 7, 17),
(38, 8, 18),
(39, 9, 18),
(40, 10, 19),
(41, 1, 19),
(42, 2, 20),
(43, 3, 20),
(44, 4, 1),
(45, 5, 2),
(46, 6, 3),
(47, 7, 4),
(48, 8, 5),
(49, 9, 6),
(50, 10, 7);

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sentBy`, `sentTo`, `status`, `message`, `created_at`) VALUES
(1, 1, 2, 'seen', 'Hey, how are you?', '2025-07-01 06:00:00'),
(2, 2, 1, 'seen', 'I am good, thanks!', '2025-07-01 06:05:00'),
(3, 3, 4, 'seen', 'Are you coming today?', '2025-07-02 07:00:00'),
(4, 4, 3, 'notseen', 'Yes, see you there.', '2025-07-02 07:10:00'),
(5, 5, 6, 'seen', 'Lunch at 1?', '2025-07-03 10:00:00'),
(6, 6, 5, 'seen', 'Sounds good.', '2025-07-03 10:10:00'),
(7, 7, 8, 'notseen', 'Did you finish the report?', '2025-07-04 12:00:00'),
(8, 8, 7, 'seen', 'Almost done.', '2025-07-04 12:30:00'),
(9, 9, 10, 'seen', 'Party tonight?', '2025-07-05 16:00:00'),
(10, 10, 9, 'notseen', 'Absolutely!', '2025-07-05 16:15:00'),
(11, 1, 3, 'seen', 'Check this out!', '2025-07-06 08:00:00'),
(12, 3, 1, 'seen', 'Looks cool.', '2025-07-06 08:05:00'),
(13, 2, 4, 'notseen', 'Meeting at 3.', '2025-07-07 13:00:00'),
(14, 4, 2, 'seen', 'Got it.', '2025-07-07 13:05:00'),
(15, 5, 7, 'notseen', 'Can you help me?', '2025-07-08 09:00:00'),
(16, 7, 5, 'seen', 'Sure thing.', '2025-07-08 09:10:00'),
(17, 6, 8, 'seen', 'Are you coming?', '2025-07-09 07:00:00'),
(18, 8, 6, 'notseen', 'Yes, on my way.', '2025-07-09 07:05:00'),
(19, 9, 1, 'seen', 'Hello!', '2025-07-10 06:00:00'),
(20, 1, 9, 'notseen', 'Hi!', '2025-07-10 06:10:00'),
(21, 10, 2, 'seen', 'Report ready?', '2025-07-11 12:00:00'),
(22, 2, 10, 'seen', 'Almost done.', '2025-07-11 12:30:00'),
(23, 3, 5, 'notseen', 'Did you get my email?', '2025-07-12 08:00:00'),
(24, 5, 3, 'seen', 'Yes, thanks.', '2025-07-12 08:10:00'),
(25, 4, 6, 'notseen', 'Call me when free.', '2025-07-13 14:00:00'),
(26, 6, 4, 'seen', 'Will do.', '2025-07-13 14:10:00'),
(27, 7, 9, 'seen', 'Game tonight?', '2025-07-14 18:00:00'),
(28, 9, 7, 'notseen', 'Count me in.', '2025-07-14 18:05:00'),
(29, 8, 10, 'seen', 'Movie later?', '2025-07-15 17:00:00'),
(30, 10, 8, 'notseen', 'Sounds good.', '2025-07-15 17:10:00');

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image`, `created_at`, `edited_at`) VALUES
(1, 1, 'Enjoying the summer vibes!', '/Instagram_Clone/assets/images/upload/post1.png', '2025-07-20', NULL),
(2, 2, 'Just cooked a delicious meal.', '/Instagram_Clone/assets/images/upload/post2.png', '2025-07-21', NULL),
(3, 3, 'Reading a great book on productivity.', '/Instagram_Clone/assets/images/upload/post21.png', '2025-07-22', NULL),
(4, 4, 'Hiking adventures are the best.', '/Instagram_Clone/assets/images/upload/post4.png', '2025-07-22', NULL),
(5, 5, 'Coffee time!', '/Instagram_Clone/assets/images/upload/post5.png', '2025-07-23', NULL),
(6, 6, 'My new art piece.', '/Instagram_Clone/assets/images/upload/post6.png', '2025-07-23', NULL),
(7, 7, 'Sunsets by the beach.', '/Instagram_Clone/assets/images/upload/post7.png', '2025-07-24', NULL),
(8, 8, 'Weekend getaway!', '/Instagram_Clone/assets/images/upload/post8.png', '2025-07-24', NULL),
(9, 9, 'Trying out new recipes.', '/Instagram_Clone/assets/images/upload/post9.png', '2025-07-25', NULL),
(10, 10, 'City lights at night.', '/Instagram_Clone/assets/images/upload/post10.png', '2025-07-25', NULL),
(11, 1, 'Weekend workout done.', '/Instagram_Clone/assets/images/upload/post11.png', '2025-07-26', NULL),
(12, 2, 'Nature walk in the forest.', '/Instagram_Clone/assets/images/upload/post12.png', '2025-07-26', NULL),
(13, 3, 'New tech gadget arrived.', '/Instagram_Clone/assets/images/upload/post13.png', '2025-07-27', NULL),
(14, 4, 'Beautiful garden blooms.', '/Instagram_Clone/assets/images/upload/post14.png', '2025-07-27', NULL),
(15, 5, 'Late night coding session.', '/Instagram_Clone/assets/images/upload/post15.png', '2025-07-28', NULL),
(16, 6, 'Freshly baked bread.', '/Instagram_Clone/assets/images/upload/post16.png', '2025-07-28', NULL),
(17, 7, 'Chilling with friends.', '/Instagram_Clone/assets/images/upload/post17.png', '2025-07-29', NULL),
(18, 8, 'Morning meditation.', '/Instagram_Clone/assets/images/upload/post18.png', '2025-07-29', NULL),
(19, 9, 'Learning guitar chords.', '/Instagram_Clone/assets/images/upload/post19.png', '2025-07-30', NULL),
(20, 10, 'Night sky full of stars.', '/Instagram_Clone/assets/images/upload/post3.png', '2025-07-30', NULL);

--
-- Dumping data for table `saved`
--

INSERT INTO `saved` (`id`, `user_id`, `post_id`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 3, 4),
(4, 4, 5),
(5, 5, 6),
(6, 6, 7),
(7, 7, 8),
(8, 8, 9),
(9, 9, 10),
(10, 10, 1),
(11, 1, 3),
(12, 2, 4),
(13, 3, 5),
(14, 4, 6),
(15, 5, 7),
(16, 6, 8),
(17, 7, 9),
(18, 8, 10),
(19, 9, 1),
(20, 10, 2),
(21, 1, 4),
(22, 2, 5),
(23, 3, 6),
(24, 4, 7),
(25, 5, 8),
(26, 6, 9),
(27, 7, 10),
(28, 8, 1),
(29, 9, 2),
(30, 10, 3),
(31, 1, 5),
(32, 2, 6),
(33, 3, 7),
(34, 4, 8),
(35, 5, 9),
(36, 6, 10),
(37, 7, 1),
(38, 8, 2),
(39, 9, 3),
(40, 10, 4),
(41, 1, 6),
(42, 2, 7),
(43, 3, 8),
(44, 4, 9),
(45, 5, 10),
(46, 6, 1),
(47, 7, 2),
(48, 8, 3),
(49, 9, 4),
(50, 10, 5);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `url`, `email`, `password`, `profile_image`, `role`, `status`, `join_at`) VALUES
(1, 'alice', 'alice', 'alice1@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_1.png', 'User', 'Active', '2025-01-01'),
(2, 'bob', 'bob', 'bob2@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_2.png', 'User', 'Active', '2025-01-02'),
(3, 'carol', 'carol', 'carol3@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_3.png', 'User', 'Active', '2025-01-03'),
(4, 'dave', 'dave', 'dave4@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_4.png', 'User', 'Active', '2025-01-04'),
(5, 'eve', 'eve', 'eve5@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_5.png', 'User', 'Active', '2025-01-05'),
(6, 'frank', 'frank', 'frank6@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_6.png', 'User', 'Active', '2025-01-06'),
(7, 'grace', 'grace', 'grace7@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_7.png', 'User', 'Active', '2025-01-07'),
(8, 'heidi', 'heidi', 'heidi8@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_8.png', 'User', 'Active', '2025-01-08'),
(9, 'ivan', 'ivan', 'ivan9@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_9.png', 'User', 'Active', '2025-01-09'),
(10, 'judy', 'judy', 'judy10@gmail.com', '$2y$10$Ut.QlwkSe25KnPRFdR0Mc.Y4vQ9HvrBahH.DKCiRypjSrCps5wzPG', '/Instagram_Clone/assets/images/upload/profile_pic_10.png', 'User', 'Active', '2025-01-10'),
(11, 'admin', 'admin', 'admin@gmail.com', '$2y$10$An291QAxW8B4e3NecA/BJ.bx3RHz.4Itll6cnpKcWYGoQr7Ud6VE6', '/Instagram_Clone/assets/images/defaultPic.png', 'Admin', 'Active', '2025-07-27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
