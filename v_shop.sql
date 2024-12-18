-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 04:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminId` int(11) NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `adminEmail` varchar(150) NOT NULL,
  `adminUser` varchar(255) NOT NULL,
  `adminPass` varchar(255) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminId`, `adminName`, `adminEmail`, `adminUser`, `adminPass`, `level`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '4297f44b13955235245b2497399d7a93', 0),
(2, 'Employee 1', 'employee1@gmail.com', 'employee1', '4297f44b13955235245b2497399d7a93', 1),
(3, 'Employee 2', 'employee2@gmail.com', 'employee2', '4297f44b13955235245b2497399d7a93', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brandId` int(10) UNSIGNED NOT NULL,
  `brandName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`brandId`, `brandName`) VALUES
(1, 'Australia'),
(2, 'America'),
(3, 'Việt Nam'),
(4, 'Korea'),
(5, 'Japan'),
(6, 'France');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cartId` int(11) NOT NULL,
  `productId` int(10) UNSIGNED NOT NULL,
  `sId` varchar(255) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catId` int(10) UNSIGNED NOT NULL,
  `catName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`catId`, `catName`) VALUES
(1, 'Rau, thịt, hoa quả'),
(2, 'Đồ uống'),
(3, 'Gạo'),
(4, 'Thực phẩm khô'),
(5, 'Chăm sóc cá nhân'),
(6, 'Gia dụng');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `cmtId` int(11) NOT NULL,
  `cmtName` varchar(255) NOT NULL,
  `cmt` text NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`cmtId`, `cmtName`, `cmt`, `product_id`) VALUES
(1, 'guest', 'chất lượng sản phẩm bền', 18),
(2, 'user1', 'đồ ăn ngon', 6),
(3, 'user1', 'sản phẩm tươi ngon', 5),
(4, 'user1', 'sản phẩm tốt', 19),
(5, 'user1', 'sản phẩm tốt', 22),
(6, 'user 2', 'chất lượng', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `name`, `address`, `phone`, `email`, `password`) VALUES
(1, 'User1', 'Hà Nội', '012345678', 'user@gmail.com', '4297f44b13955235245b2497399d7a93'),
(2, 'User2', 'Hà Nội', '0123456789', 'user2@gmail.com', '4297f44b13955235245b2497399d7a93');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `productId` int(10) UNSIGNED NOT NULL,
  `productName` varchar(255) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_order` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `productId`, `productName`, `customer_id`, `quantity`, `price`, `image`, `status`, `date_order`) VALUES
(1, 9, 'Gạo đen Hoa Sữa', 1, 1, '50000', '3b73bae5a8.jpg', 0, '2024-12-18 22:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `productId` int(10) UNSIGNED NOT NULL,
  `productName` tinytext NOT NULL,
  `catId` int(10) UNSIGNED NOT NULL,
  `brandId` int(10) UNSIGNED NOT NULL,
  `product_desc` text NOT NULL,
  `type` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`productId`, `productName`, `catId`, `brandId`, `product_desc`, `type`, `price`, `quantity`, `image`) VALUES
(1, 'Kiwi', 1, 4, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 0, '90000', 18, 'e8a3aab3aa.png'),
(2, 'Cherries', 1, 2, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '300000', 20, '73bd9c29c4.jpg'),
(3, 'Táo Úc', 1, 1, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '70000', 20, '42127d9b6c.jpg'),
(4, 'Dâu Tây', 1, 3, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '110000', 20, '43bf201cde.jpg'),
(5, 'Khổ qua', 1, 3, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 0, '22000', 20, 'b4077607cd.jpg'),
(6, 'Súp lơ trắng', 1, 4, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '43000', 20, '39c5a00db2.jpg'),
(7, 'Củ cải đỏ', 1, 2, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '30000', 20, 'afa4e68509.jpg'),
(8, 'Coca cola', 2, 2, '<p><span>Loại Coca-Cola được pha nhầm đ&oacute; lại ngon miệng hơn b&igrave;nh thường, l&agrave;m sảng kho&aacute;i kh&aacute;c thường v&agrave; l&uacute;c đ&oacute; Coca-Cola mới c&oacute; thể phục vụ số đ&ocirc;ng người ti&ecirc;u d&ugrave;ng</span></p>', 0, '50000', 20, '2068157666.png'),
(9, 'Gạo đen Hoa Sữa', 3, 4, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 0, '50000', 19, '3b73bae5a8.jpg'),
(10, 'Gạo Nàng Thơm', 3, 3, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '12000', 20, '7481b72f3a.jpg'),
(11, 'Gạo Lứt Huyết Rồng Loại 1', 3, 2, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '30000', 20, '2ad4a3f42f.jpg'),
(12, 'Gạo Hương Lài', 3, 1, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '17000', 20, '09e9aba47d.jpg'),
(13, 'ORGANIC GOJI BERRIES 100GR', 4, 4, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 0, '200000', 20, '6d86160c73.png'),
(14, 'ORGANIC HULLED MILLET 500GR', 4, 3, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '50000', 20, '66343b2171.png'),
(15, 'ORGANIC MUNG BEAN 500GR', 4, 2, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '700000', 20, '6ff527128e.png'),
(16, 'ORGANIC CINNAMON POWDER 100GR', 4, 1, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '600000', 20, '1c80ae2164.png'),
(17, 'Bắp cải tím', 1, 1, '<p>Thực phẩm hữu cơ l&agrave; thực phẩm được sản xuất bằng phương ph&aacute;p tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn của canh t&aacute;c hữu cơ. C&aacute;c ti&ecirc;u chuẩn kh&aacute;c nhau tr&ecirc;n to&agrave;n thế giới, nhưng canh t&aacute;c hữu cơ n&oacute;i chung c&oacute; c&aacute;c đặc điểm thực h&agrave;nh nhằm cố gắng lu&acirc;n chuyển t&agrave;i nguy&ecirc;n, th&uacute;c đẩy c&acirc;n bằng sinh th&aacute;i v&agrave; bảo tồn đa dạng sinh học.</p>', 1, '30000', 20, '523b61dc52.jpg'),
(18, 'Nồi chiên không dầu Rapido RAF-8.0M 8 lít', 6, 4, '<p><em><strong>Nồi chi&ecirc;n kh&ocirc;ng dầu Rapido RAF-8.0M 8 l&iacute;t</strong></em><span>&nbsp;</span><strong><em>dễ sử dụng với 2 n&uacute;t xoay đơn giản, chi&ecirc;n nướng thoải m&aacute;i cho cả gia đ&igrave;nh nhờ</em></strong><em><strong>&nbsp;<a title=\"Xem th&ecirc;m c&aacute;c mẫu nồi chi&ecirc;n kh&ocirc;ng dầu 5 - 10 l&iacute;t đang b&aacute;n tại Điện m&aacute;y XANH\" href=\"https://www.dienmayxanh.com/noi-chien-khong-dau-tu-5-den-10-lit\" target=\"_blank\">dung t&iacute;ch sử dụng lớn 8 l&iacute;t</a></strong></em><strong><em>, chất liệu bền tốt v&agrave; an to&agrave;n khi nấu.</em></strong></p>', 1, '1490000', 20, '17fd1deb27.png'),
(19, 'Bếp điện từ đơn Kangaroo KG18IH2', 6, 3, '<p><span>Bếp điện từ đơn Kangaroo KG18IH2</span><span>&nbsp;</span><span>l&agrave; sản phẩm hữu &iacute;ch, tiết kiệm thời gian nấu nướng, sạch sẽ an to&agrave;n v&agrave; được rất nhiều người lựa chọn v&agrave; được d&ugrave;ng kh&aacute; phổ biến ở nhiều gia đ&igrave;nh v&agrave; nhờ khả năng l&agrave;m n&oacute;ng nhanh v&agrave; được t&iacute;ch hợp nhiều t&iacute;nh năng tiện &iacute;ch.</span></p>', 1, '1290000', 20, '96b8f1b69c.png'),
(20, 'Nước tẩy trang Bioderma 500ml', 5, 6, '<p>Loại da: Da dầu, da nhạy cảm</p>\r\n<p>C&ocirc;ng dụng: Gi&uacute;p cho l&agrave;n da được l&agrave;m sạch s&acirc;u v&agrave; duy tr&igrave; độ ẩm tự nhi&ecirc;n của da một c&aacute;ch hiệu quả.</p>', 1, '274000', 20, 'a2b7322af8.png'),
(21, 'Sữa Rửa Mặt CeraVe Foaming Facial Cleanser', 5, 2, '<p><span>Cerave Foaming Facial Cleanser</span><span>&nbsp;l&agrave; d&ograve;ng sữa rửa mặt được khuy&ecirc;n d&ugrave;ng h&agrave;ng ng&agrave;y cho mọi loại da, từ da thường đến da dầu, da mụn, kể cả l&agrave; da nhạy cảm. Sữa rửa mặt Cerave c&oacute; độ dịu nhẹ, th&acirc;n thiện với da, c&oacute; khả năng l&agrave;m sạch da, loại bỏ dầu thừa nhẹ nh&agrave;ng, kh&ocirc;ng g&acirc;y kh&ocirc; r&aacute;p nhờ độ pH l&yacute; tưởng. Ngo&agrave;i ra n&oacute; c&ograve;n gi&uacute;p giảm mụn, se kh&iacute;t lỗ ch&acirc;n l&ocirc;ng.</span></p>', 0, '236000', 18, 'be67c65487.png'),
(22, 'Nước tăng lực Asahi Monster Energy 355mL', 2, 5, '<p><span>Nước tăng lực Asahi Monster Energy với h&agrave;m lượng caffeine khoảng 120 mg trong một lon nước c&oacute; dung t&iacute;ch 355ml gi&uacute;p đem đến sinh lực dồi d&agrave;o v&agrave; minh mẫn, đ&aacute;nh thức năng lượng hoạt động cả ng&agrave;y d&agrave;i. Đ&acirc;y ch&iacute;nh l&agrave; thức uống l&yacute; tưởng với những c&ocirc;ng việc đ&ograve;i hỏi tập trung cao hay phải di chuyển nhiều.</span><span><span><em>&nbsp;</em></span></span></p>', 1, '68000', 20, '09ccb76648.png'),
(23, 'Thịt Ba Rọi Heo', 1, 3, '<p><span>Ba Rọi Heo CJ gi&uacute;p cung cấp lượng lớn protein, &iacute;t chất b&eacute;o gi&uacute;p ph&aacute;t triển cơ bắp. Thịt ba rọi chứa nhiều vitamin nh&oacute;m B. Hỗ trợ duy tr&igrave; hoạt động, cung cấp năng lượng cho cơ thể. Vitamin B2 c&oacute; lợi cho da, c&oacute; t&aacute;c dụng giải độc. Tốt cho n&atilde;o v&agrave; c&aacute;c tế b&agrave;o thần kinh, nhờ c&oacute; vitamin A, D trong th&agrave;nh phần dinh dưỡng.</span><br /><span>Hướng dẫn bảo quản: Bảo quản m&aacute;t ở nhiệt độ 0-4 độ C, trong v&ograve;ng 3 ng&agrave;y kể từ ng&agrave;y sản xuất.</span></p>', 1, '60000', 20, 'fcf87cdb86.png'),
(24, 'Thịt Thăn Lưng Bò Tuyết', 1, 3, '<p><span>T&ecirc;n sản phẩm: Thăn lưng b&ograve; tuyết (Nh&atilde;n hiệu Aukobe)</span><br /><span>Th&agrave;nh phần: Thịt b&ograve;, mỡ b&ograve;, nước, chất l&agrave;m ẩm,&hellip;</span><br /><span>Hướng dẫn sử dụng: D&ugrave;ng chế biến th&agrave;nh m&oacute;n ăn t&ugrave;y th&iacute;ch. Sản phẩm c&oacute; chế biến ngay kh&ocirc;ng cần r&atilde; đ&ocirc;ng, kh&ocirc;ng t&aacute;i cấp đ&ocirc;ng lại sản phẩm.</span><br /><span>Hướng dẫn bảo quản: Bảo quản ở nhiệt độ: -18 độ C hoặc trong ngăn đ&ocirc;ng tủ lạnh</span></p>', 0, '135000', 20, '493988f52d.png'),
(25, 'Thịt Ba Rọi Xông Khói', 1, 3, '<p><span>Được tuyển chọn từ phần ba rọi tươi ngon nhất của những ch&uacute; heo non dưới 50kg với c&ocirc;ng nghệ x&ocirc;ng kh&oacute;i tự nhi&ecirc;n bằng gỗ sồi, Ba rọi x&ocirc;ng kh&oacute;i Shinshu Nhật Bản giữ trọn vị ngọt thanh của thịt h&ograve;a quyện c&ugrave;ng lớp mỡ mịn m&agrave;ng nhưng lại kh&ocirc;ng hề b&eacute;o ngậy, đem đến cho bạn cảm gi&aacute;c ngất ng&acirc;y khi thưởng thức từng miếng thịt mềm, tan trong miệng. Ba rọi x&ocirc;ng kh&oacute;i Shinshu ngon hơn khi nướng hoặc &aacute;p chảo.</span></p>', 1, '75000', 20, '2b386667e5.png'),
(26, 'Thịt Ba Chỉ Bò Úc', 1, 3, '<p><span>Đặc điểm sản phẩm:</span><br /><span>- Phần thịt c&oacute; m&agrave;u đỏ, xen kẽ v&acirc;n mỡ c&oacute; m&agrave;u trắng, tuy nhi&ecirc;n &iacute;t hơn thịt b&ograve; Mỹ</span><br /><span>- Phần thịt d&agrave;y xen kẽ với mỡ với tỉ lệ mỡ cao n&ecirc;n tạo cho miếng thịt c&oacute; độ thơm, mềm, kh&ocirc;ng bị kh&ocirc; khi chế biến</span></p>', 1, '100000', 20, '0a525e644d.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `sliderId` int(11) NOT NULL,
  `sliderName` varchar(255) NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`sliderId`, `sliderName`, `slider_image`, `type`) VALUES
(1, 'slide1', '82aba99c1f.png', 1),
(2, 'slide2', '0c2c957440.png', 1),
(3, 'slide3', '1a05c05738.png', 1),
(4, 'slide4', '8811787002.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thongke`
--

CREATE TABLE `tbl_thongke` (
  `id` int(11) NOT NULL,
  `created_date` varchar(30) NOT NULL,
  `orders` int(11) NOT NULL,
  `sales` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brandId`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cartId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catId`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`cmtId`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`,`productName`),
  ADD KEY `productName` (`productName`,`customer_id`),
  ADD KEY `productName_2` (`productName`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `catId` (`catId`,`brandId`),
  ADD KEY `brandId` (`brandId`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`sliderId`);

--
-- Indexes for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brandId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `cmtId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `productId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `sliderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_thongke`
--
ALTER TABLE `tbl_thongke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `tbl_product` (`productId`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_order_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `tbl_product` (`productId`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_1` FOREIGN KEY (`brandId`) REFERENCES `tbl_brand` (`brandId`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_ibfk_2` FOREIGN KEY (`catId`) REFERENCES `tbl_category` (`catId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
