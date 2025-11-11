-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th10 21, 2025 lúc 04:45 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shophoa`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `MaAdmin` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `VaiTro` varchar(50) DEFAULT 'Nhân viên',
  `TrangThai` varchar(30) DEFAULT 'Hoạt động',
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`MaAdmin`, `HoTen`, `Email`, `MatKhau`, `SDT`, `VaiTro`, `TrangThai`, `NgayTao`) VALUES
(1, 'Nguyễn Thị Phuong Anh', 'admin@ShopHoa.vn', '$2y$10$hhgiHPBeUyc9XxVSOs.AFuOgSehBalkiCK/ZDN0s0POZ2Kx.4I5na', '0909999999', 'Quản trị viên', 'Hoạt động', '2025-10-19 17:42:45'),
(2, 'Trần Thu Hằng', 'hang@hoayeuthuong.vn', 'hang123', '0911111111', 'Nhân viên kho', 'Hoạt động', '2025-10-19 17:42:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baiviet`
--

CREATE TABLE `baiviet` (
  `MaBV` int(11) NOT NULL,
  `TieuDe` varchar(200) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `TacGia` varchar(100) DEFAULT NULL,
  `NgayDang` datetime DEFAULT current_timestamp(),
  `TrangThai` varchar(30) DEFAULT 'Hiển thị',
  `HinhAnh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `baiviet`
--

INSERT INTO `baiviet` (`MaBV`, `TieuDe`, `NoiDung`, `TacGia`, `NgayDang`, `TrangThai`, `HinhAnh`) VALUES
(1, 'Ý nghĩa của hoa hồng đỏ', 'Hoa hồng đỏ tượng trưng cho tình yêu nồng nàn...', 'Nguyễn Văn Quản', '2025-10-19 17:42:45', 'Hiển thị', 'hongdo.jpg'),
(2, 'Cách chọn hoa cưới phù hợp', 'Hoa cưới mang thông điệp yêu thương và hạnh phúc...', 'Trần Thu Hằng', '2025-10-19 17:42:45', 'Hiển thị', 'hoacuoi.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

CREATE TABLE `banner` (
  `MaBanner` int(11) NOT NULL,
  `TieuDe` varchar(150) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `DuongDan` varchar(255) DEFAULT NULL,
  `ViTri` varchar(50) DEFAULT 'Trang chủ',
  `TrangThai` varchar(30) DEFAULT 'Hiển thị',
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `banner`
--

INSERT INTO `banner` (`MaBanner`, `TieuDe`, `HinhAnh`, `DuongDan`, `ViTri`, `TrangThai`, `NgayTao`) VALUES
(1, 'Giảm 20% mùa cưới', 'banner1.jpg', '/khuyen-mai', 'Trang chủ', 'Hiển thị', '2025-10-19 17:42:45'),
(2, 'Giao hoa miễn phí toàn quốc', 'banner2.jpg', '/giao-hang', 'Trang chủ', 'Hiển thị', '2025-10-19 17:42:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chatsupport`
--

CREATE TABLE `chatsupport` (
  `MaChat` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `ThoiGian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chatsupport`
--

INSERT INTO `chatsupport` (`MaChat`, `MaKH`, `NoiDung`, `ThoiGian`) VALUES
(1, 1, 'Mình muốn đổi địa chỉ giao hàng đơn #1 được không?', '2025-10-19 17:42:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chinhanh`
--

CREATE TABLE `chinhanh` (
  `MaCN` int(11) NOT NULL,
  `TenChiNhanh` varchar(150) DEFAULT NULL,
  `DiaChi` text DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `GioMoCua` time DEFAULT NULL,
  `GioDongCua` time DEFAULT NULL,
  `TrangThai` varchar(30) DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chinhanh`
--

INSERT INTO `chinhanh` (`MaCN`, `TenChiNhanh`, `DiaChi`, `SDT`, `Email`, `GioMoCua`, `GioDongCua`, `TrangThai`) VALUES
(1, 'FLOWER\'LNA - Quận 1', '25 Nguyễn Thị Minh Khai, Q.1, TP.HCM', '0908111222', 'q1@hoayeuthuong.vn', '08:00:00', '20:00:00', 'Hoạt động'),
(2, 'FLOWER\'LNA - Quận 7', '12 Nguyễn Văn Linh, Q.7, TP.HCM', '0908222333', 'q7@hoayeuthuong.vn', '08:00:00', '20:00:00', 'Hoạt động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDon` int(11) NOT NULL,
  `MaHoa` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `DonGia` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDon`, `MaHoa`, `SoLuong`, `DonGia`) VALUES
(1, 1, 2, 450000.00),
(1, 3, 1, 820000.00),
(2, 4, 1, 520000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chude`
--

CREATE TABLE `chude` (
  `MaChuDe` int(11) NOT NULL,
  `TenChuDe` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chude`
--

INSERT INTO `chude` (`MaChuDe`, `TenChuDe`, `MoTa`) VALUES
(1, 'Sinh nhật', 'Hoa dành tặng sinh nhật'),
(2, 'Tình yêu', 'Dành cho người thương'),
(3, 'Chúc mừng', 'Hoa chúc mừng khai trương, tốt nghiệp...'),
(4, 'Tri ân', 'Hoa tặng thầy cô, cha mẹ, khách hàng'),
(5, 'Khai trương', 'Hoa chúc mừng khai trương cửa hàng, công ty, khởi nghiệp thành công'),
(6, 'Chia buồn', 'Hoa chia sẻ nỗi buồn, lời tiễn đưa chân thành đến người đã khuất'),
(7, 'Chúc sức khỏe', 'Hoa gửi tặng lời chúc bình an, mạnh khỏe đến người thân, bạn bè'),
(8, 'Cảm ơn', 'Hoa gửi lời cảm ơn chân thành đến người nhận'),
(9, 'Mừng tốt nghiệp', 'Hoa chúc mừng thành công và những cột mốc đáng nhớ trong cuộc sống');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `MaDG` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `MaHoa` int(11) DEFAULT NULL,
  `SoSao` int(11) DEFAULT NULL CHECK (`SoSao` between 1 and 5),
  `NoiDung` text DEFAULT NULL,
  `NgayDG` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`MaDG`, `MaKH`, `MaHoa`, `SoSao`, `NoiDung`, `NgayDG`) VALUES
(1, 1, 1, 5, 'Hoa tươi và gói rất đẹp!', '2025-10-19 17:42:28'),
(2, 2, 3, 4, 'Lan tím nở đẹp, giao nhanh.', '2025-10-19 17:42:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachigiaohang`
--

CREATE TABLE `diachigiaohang` (
  `MaDiaChi` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `TenNguoiNhan` varchar(100) DEFAULT NULL,
  `SDTNhan` varchar(15) DEFAULT NULL,
  `DiaChiNhan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `diachigiaohang`
--

INSERT INTO `diachigiaohang` (`MaDiaChi`, `MaKH`, `TenNguoiNhan`, `SDTNhan`, `DiaChiNhan`) VALUES
(1, 1, 'Nguyễn Thị Mai', '0905123456', '25 Nguyễn Thị Minh Khai, Q.1'),
(2, 2, 'Trần Văn Nam', '0905789456', '98 Nguyễn Tri Phương, Q.10'),
(3, 3, 'Lê Hoàng Yến', '0906234567', '12 Cách Mạng Tháng 8, Q.3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDon` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `NgayDat` datetime DEFAULT current_timestamp(),
  `TongTien` decimal(12,2) DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT 'Chờ xác nhận',
  `HinhThucThanhToan` varchar(50) DEFAULT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDon`, `MaKH`, `NgayDat`, `TongTien`, `TrangThai`, `HinhThucThanhToan`, `GhiChu`) VALUES
(1, 1, '2025-10-19 17:42:28', 920000.00, 'Đang giao', 'COD', NULL),
(2, 2, '2025-10-19 17:42:28', 520000.00, 'Đã giao', 'Chuyển khoản', NULL),
(3, 4, '2025-10-20 23:01:23', 2250000.00, 'Chờ xác nhận', 'COD', 'panh text'),
(8, 4, '2025-10-21 00:22:40', 700000.00, 'Chờ xác nhận', 'COD', 'donmoi'),
(9, 4, '2025-10-21 09:07:40', 8550000.00, 'Chờ xác nhận', 'COD', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGio` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGio`, `MaKH`, `NgayTao`) VALUES
(1, 1, '2025-10-19 17:42:28'),
(2, 2, '2025-10-19 17:42:28'),
(3, 4, '2025-10-20 23:18:13'),
(4, 4, '2025-10-20 23:20:58'),
(5, 4, '2025-10-20 23:33:41'),
(6, 4, '2025-10-20 23:42:30'),
(7, 4, '2025-10-21 00:22:40'),
(8, 4, '2025-10-21 09:07:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohangchitiet`
--

CREATE TABLE `giohangchitiet` (
  `MaGio` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `LoaiSanPham` enum('hoa','phukien') NOT NULL DEFAULT 'hoa',
  `SoLuong` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohangchitiet`
--

INSERT INTO `giohangchitiet` (`MaGio`, `MaSP`, `LoaiSanPham`, `SoLuong`) VALUES
(1, 0, 'hoa', 2),
(2, 0, 'hoa', 1),
(3, 0, 'hoa', 1),
(4, 0, 'hoa', 1),
(6, 5, 'hoa', 1),
(6, 15, 'hoa', 1),
(6, 16, 'hoa', 1),
(7, 5, 'hoa', 1),
(8, 5, 'hoa', 4),
(8, 17, 'hoa', 3),
(8, 18, 'hoa', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhanh`
--

CREATE TABLE `hinhanh` (
  `MaHinh` int(11) NOT NULL,
  `MaHoa` int(11) DEFAULT NULL,
  `URLHinh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa`
--

CREATE TABLE `hoa` (
  `MaHoa` int(11) NOT NULL,
  `TenHoa` varchar(150) NOT NULL,
  `Gia` decimal(12,2) NOT NULL,
  `GiaCu` decimal(12,2) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT 0,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `MauSac` varchar(50) DEFAULT NULL,
  `Tag` enum('NEW','SALE','FREESHIP','HOT','NONE') DEFAULT 'NONE',
  `MoTa` text DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `MaLoai` int(11) DEFAULT NULL,
  `MaChuDe` int(11) DEFAULT NULL,
  `TrangThai` enum('Còn hàng','Hết hàng','Ngừng bán') DEFAULT 'Còn hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoa`
--

INSERT INTO `hoa` (`MaHoa`, `TenHoa`, `Gia`, `GiaCu`, `SoLuong`, `HinhAnh`, `MauSac`, `Tag`, `MoTa`, `NgayTao`, `MaLoai`, `MaChuDe`, `TrangThai`) VALUES
(1, 'Bông hoa đẹp nhất', 700000.00, NULL, 10, 'hoa1.jpg', 'Đỏ', 'FREESHIP', 'Hoa tươi nhập khẩu.', '2025-10-19 23:36:00', 1, 1, 'Ngừng bán'),
(2, 'Hidden feelings', 700000.00, 800000.00, 6, '', '', 'SALE', 'Bó hoa tình yêu ấn tượng.', '2025-10-19 23:36:00', 1, 1, 'Ngừng bán'),
(3, 'My girl 02', 950000.00, 0.00, 1, '', '', 'NEW', 'Hoa mix theo phong cách hiện đại.', '2025-10-19 23:36:00', 2, 1, 'Ngừng bán'),
(4, 'Lux mica flower 14', 1300000.00, 0.00, 3, '', '', 'FREESHIP', 'Set hoa mica sang trọng.', '2025-10-19 23:36:00', 2, 1, 'Ngừng bán'),
(5, 'Bông hoa đẹp nhất', 700000.00, 730000.00, 20, '12909_bong-hoa-dep-nhat.jpg', 'Hồng', 'HOT', 'Giữa hàng ngàn loại hoa trên đời, bông hoa đẹp nhất có lẽ chính là người phụ nữ bên cạnh bạn, là mẹ, bà, người chị, người em gái nhỏ. Họ chính là những bông hoa tỏa sáng rực rỡ nhất giúp cuộc sông của bạn luôn cảm thấy có ý nghĩa. Sản phẩm bao gồm: Cẩm chướng đơn hồng nhạt: 7 Cát tường trắng: 4 Cúc calimero hồng : 5 Hoa baby : 1 Hồng da: 5 Hồng Lạc Thần: 5 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 13:06:41', 1, 1, 'Còn hàng'),
(6, 'Hoa tươi màu đỏ', 300000.00, 350000.00, 0, '11740_dieu-bat-ngo.png', 'Đỏ', 'SALE', 'Với hương thơm nhẹ nhàng cũng màu sắc nổi bật, những đóa hồng đỏ ớt đã dễ dàng chiếm được tình cảm của những người yêu hoa. Một bó hoa kiểu dáng đơn giản và được gửi tặng đến người nhận không cần nhân một dịp gì thì chắc chắn sẽ là một món quà tinh thần đầy ý nghĩa giúp họ có một ngày tuyệt vời hơn đấy nhé. Sản phẩm bao gồm: Hoa thạch thảo trắng: 1 Hồng đỏ ớt : 12 Lá phụ khác: 1 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 13:52:12', 1, 2, 'Hết hàng'),
(7, 'Hoa tươi màu đỏ', 300000.00, 350000.00, 5, '11740_dieu-bat-ngo.png', 'Đỏ', 'SALE', 'Với hương thơm nhẹ nhàng cũng màu sắc nổi bật, những đóa hồng đỏ ớt đã dễ dàng chiếm được tình cảm của những người yêu hoa. Một bó hoa kiểu dáng đơn giản và được gửi tặng đến người nhận không cần nhân một dịp gì thì chắc chắn sẽ là một món quà tinh thần đầy ý nghĩa giúp họ có một ngày tuyệt vời hơn đấy nhé. Sản phẩm bao gồm: Hoa thạch thảo trắng: 1 Hồng đỏ ớt : 12 Lá phụ khác: 1 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 13:52:57', 1, 2, 'Còn hàng'),
(8, 'Me before you', 650000.00, 700000.00, 15, '4618_me-before-you.jpg', 'Đỏ', 'SALE', 'Lấy cảm hứng từ bộ phim tình cảm “Me before you”, mẫu hoa cùng tên mang đến thông điệp ý nghĩa về sức mạnh của tình yêu và cách mà tình yêu làm thay đổi mỗi người. Tặng bó hoa “Me before you’ cho một người nghĩa là ta rất thương yêu, quý trọng và đề cao họ. Sản phẩm bao gồm: Hồng đỏ Pháp: 30 Đinh lăng : 7 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 13:54:13', 1, 2, 'Còn hàng'),
(9, 'All of love', 625000.00, 650000.00, 5, '8524_all-of-love.jpg', 'Đỏ', 'SALE', 'Mẫu hoa hồng đỏ này tượng trưng cho tình yêu và sự kính trọng to lớn của con dành cho Mẹ. Mẹ luôn là người tuyệt vời và cao cả nhất trong cuộc đời của con. Sản phẩm bao gồm: Hoa Sao tím: 3 Hồng đỏ Pháp: 25 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:04:11', 1, 2, 'Còn hàng'),
(10, 'Mây ngàn', 500000.00, 500000.00, 0, '11613_may-ngan.jpg', 'Đỏ', 'NONE', 'Được thiết kế từ hoa hồng đỏ kết hợp với cát tường trắng và calimero trắng, mẫu hoa mang một sắc màu tươi sáng, rực rỡ, và nhiều hi vọng về môt tương lai sáng lạn. \"Mây ngàn\" chính là một món quà gửi đến lời chúc tốt lành, may mắn và hạnh phúc cho người nhận. Sản phẩm bao gồm: Cát tường trắng: 3 Chuỗi ngọc đỏ : 5 Cúc calimero trắng: 3 Hồng đỏ sa : 10 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:06:06', 1, 1, 'Còn hàng'),
(11, 'Love you more', 550000.00, 550000.00, 3, '8039_love-you-more.jpg', 'Đỏ', 'HOT', 'Anh tặng em hoa hồng đỏ là tặng cho em cả thể giới của anh, anh khẳng định rằng 100% anh yêu em, không có bất cứ điều gì có thể sánh bằng tình yêu anh dành cho em. Sản phẩm bao gồm: Hồng đỏ Ecuador DL: 12 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:08:10', 1, 2, 'Còn hàng'),
(12, 'Real Love', 1500000.00, 1550000.00, 5, '5045_real-love.jpg', 'Đỏ', 'HOT', 'Anh tặng em hoa hồng đỏ là tặng cho em cả thể giới của anh, anh khẳng định rằng 100% anh yêu em, không có bất cứ điều gì có thể sánh bằng tình yêu anh dành cho em. Sản phẩm bao gồm: Hồng đỏ Ecuador DL: 12 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:08:41', 1, 2, 'Còn hàng'),
(13, 'Vươn cao', 1500000.00, 1700000.00, 2, '11031_vuon-cao.png', 'Đỏ', 'HOT', 'Thành công là cả môt quá trình, một con đường mà bất kì ai cũng muốn được bước đi, nhưng mấy ai kiên trì và nhẫn nại để bước tới đến vinh quang của nó. Thành công đôi khi là mục tiêu nhưng đôi khi là môt chặng đường gian nan đòi hỏi ở người đi môt cái nhìn lạc quan và niềm tin mạnh mẽ để lên đỉnh thành công. Kệ hoa được tao ra thể hiện lời chúc mừng trong ngày vui của người tặng đến gia chủ. Sản phẩm bao gồm: Hồng đỏ sa : 50 Lan Moka đỏ: 10 Mõm sói trắng : 15 Môn đỏ: 11 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:11:39', 1, 3, 'Còn hàng'),
(14, 'You and Me', 7500000.00, 750000.00, 2, '8774_you-and-me.jpg', 'Đỏ', 'HOT', 'Bó hoa hồng ecuador explorer đỏ rực rỡ tượng trưng cho tình yêu nồng cháy, chân thành và bất diệt. Với cách gói giấy đen sang trọng cùng nơ đỏ nổi bật, bó hoa này thể hiện sự đẳng cấp và tinh tế. Phù hợp để tặng người yêu, vợ hoặc trong các dịp lãng mạn như Valentine, lễ kỷ niệm tình yêu. Sản phẩm bao gồm: Hồng ecuador explorer NK: 50 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:14:00', 1, 2, 'Còn hàng'),
(15, 'White roses', 350000.00, 450000.00, 10, '10258_white-roses.jpg', 'Trắng', 'HOT', 'Bó hoa mix 9 cành hồng trắng, babi và lá bạc tượng trưng cho tình yêu thuần khiết và mãi bất diệt. Vì vậy các cặp đôi thường dành tặng cho nhau bó hoa với 9 bông hoa hồng trong ngày lễ tình nhân, ngày sinh nhật hay trong những ngày kỷ niệm đặc biệt để khẳng định tình yêu mà mình dành cho đối phương. Sản phẩm bao gồm: Hoa baby : 1 Hồng trắng cồ: 9 Lá bạc : 2 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:15:29', 1, 2, 'Còn hàng'),
(16, 'Vĩnh biệt', 1200000.00, 1500000.00, 3, '3064_vinh-biet.jpg', 'Trắng', 'FREESHIP', 'Trong cuộc sống chúng ta mất bất cứ thứ gì chúng ta cũng có thể có lại được , nhưng khi chúng ta mất vĩnh viễn một người thân hay một người bạn chúng ta không bao giờ tìm lại được. Với vòng hoa chia buồn Vĩnh biệt 2 sẽ thay mặt bạn đưa tiễn họ và chia sẻ cùng gia đình họ. Sản phẩm bao gồm: Cúc calimero tím: 10 Cúc trắng : 15 Hồng tím cà: 22 Lan vườn tím: 10 Đồng tiền trắng : 10 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:19:24', 2, 6, 'Còn hàng'),
(17, 'Luyến Tiếc', 1600000.00, 1600000.00, 3, '3087_luyen-tiec.jpg', 'Trắng', 'FREESHIP', 'Trong cuộc sống chúng ta mất bất cứ thứ gì chúng ta cũng có thể có lại được, nhưng khi chúng ta mất vĩnh viễn một người thân hay một người bạn chúng ta không bao giờ tìm lại được. Với vòng hoa chia buồn Luyến Tiếc I được kết từ hoa Hồng Trắng, hoa Lan Thái và các phụ liệu khác chúng tôi sẽ thay mặt bạn đưa tiễn họ và chia sẻ cùng gia đình họ. Sản phẩm bao gồm: Cát tường trắng: 10 Cúc trắng : 10 Hoa mimi: 10 Hồng trắng nhí: 30 Lan trắng vườn : 10 Lily trắng: 5 Môn trắng: 5 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:20:32', 9, 6, 'Còn hàng'),
(18, 'Party', 950000.00, 1000000.00, 4, '13223_party.jpg', 'Cam', 'NEW', 'Sản phẩm bao gồm: Cúc calimero vàng nhụy nâu : 10 Hoa baby : 1 Hồng cam party: 15 Hồng trứng gà : 5 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:23:48', 2, 5, 'Còn hàng'),
(19, 'Luxury vase', 2200000.00, 2250000.00, 4, '12577_luxury-vase.jpg', 'Tím', 'NEW', 'Sản phẩm bao gồm: Cúc mai hồng: 7 Hồ điệp tím: 1 Hồng môn tím: 10 Hồng tím cà: 26 Lá bạc : 1 Lá trúc nâu: 3 Pink OHara: 10 Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', '2025-10-20 14:24:29', 2, 5, 'Còn hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DiaChi` text DEFAULT NULL,
  `MatKhau` varchar(255) DEFAULT NULL,
  `NgayDangKy` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `HoTen`, `Email`, `SDT`, `DiaChi`, `MatKhau`, `NgayDangKy`) VALUES
(1, 'Nguyễn Thị Mai', 'mai.nguyen@gmail.com', '0905123456', 'Q.3, TP.HCM', '123456', '2025-10-19 17:42:28'),
(2, 'Trần Văn Nam', 'nam.tran@gmail.com', '0905789456', 'Q.10, TP.HCM', '123456', '2025-10-19 17:42:28'),
(3, 'Lê Hoàng Yến', 'yen.le@gmail.com', '0906234567', 'Q.1, TP.HCM', '123456', '2025-10-19 17:42:28'),
(4, 'Phuong Anh', 'duongnguyen.100497@gmail.com', '123567', 'bthanh', '$2y$10$hhgiHPBeUyc9XxVSOs.AFuOgSehBalkiCK/ZDN0s0POZ2Kx.4I5na', '2025-10-20 10:31:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MaKM` int(11) NOT NULL,
  `TenKM` varchar(100) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `PhanTramGiam` int(11) DEFAULT NULL,
  `NgayBatDau` date DEFAULT NULL,
  `NgayKetThuc` date DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT 'Còn hạn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `TenKM`, `NoiDung`, `PhanTramGiam`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`) VALUES
(1, 'Giảm 10% mùa cưới', 'Áp dụng cho hoa tình yêu', 10, '2025-10-01', '2025-11-30', 'Còn hạn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lienhe`
--

CREATE TABLE `lienhe` (
  `MaLH` int(11) NOT NULL,
  `TenKH` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `NgayGui` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lienhe`
--

INSERT INTO `lienhe` (`MaLH`, `TenKH`, `Email`, `NoiDung`, `NgayGui`) VALUES
(1, 'Nguyễn Thị Mai', 'mai.nguyen@gmail.com', 'Shop có nhận đặt hoa theo yêu cầu không?', '2025-10-19 17:42:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaihoa`
--

CREATE TABLE `loaihoa` (
  `MaLoai` int(11) NOT NULL,
  `TenLoai` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaihoa`
--

INSERT INTO `loaihoa` (`MaLoai`, `TenLoai`, `MoTa`) VALUES
(1, 'Hoa Hồng', 'Biểu tượng của tình yêu, sự lãng mạn'),
(2, 'Hoa Cúc', 'Tượng trưng cho sự trong sáng và trung thực'),
(3, 'Hoa Lan', 'Loài hoa cao quý, tinh tế'),
(4, 'Hoa Lily', 'Mang ý nghĩa thanh khiết và kiêu sa'),
(5, 'Hoa Hướng Dương', 'Tượng trưng cho niềm tin, hy vọng và nghị lực vươn lên'),
(6, 'Hoa Đồng Tiền', 'Biểu tượng của hạnh phúc, may mắn và tài lộc'),
(7, 'Lan Hồ Điệp', 'Loài hoa quý phái, tượng trưng cho sự sang trọng và thành công'),
(8, 'Hoa Cẩm Chướng', 'Thể hiện tình yêu, lòng ngưỡng mộ và sự biết ơn'),
(9, 'Hoa Cát Tường', 'Mang đến may mắn, thịnh vượng và tình yêu bền chặt'),
(10, 'Baby Flower', 'Hoa nhỏ xinh tượng trưng cho sự tinh khôi và ngây thơ'),
(11, 'Hoa Cúc', 'Biểu tượng của sự trường thọ, kiên định và trung thực'),
(12, 'Sen Đá', 'Loài cây tượng trưng cho tình yêu vĩnh cửu và sức sống mạnh mẽ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaiphukien`
--

CREATE TABLE `loaiphukien` (
  `MaLoaiPK` int(11) NOT NULL,
  `TenLoaiPK` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaiphukien`
--

INSERT INTO `loaiphukien` (`MaLoaiPK`, `TenLoaiPK`, `MoTa`) VALUES
(1, 'Gấu bông', 'Các loại gấu bông đáng yêu tặng kèm hoa.'),
(2, 'Nến thơm', 'Nến trang trí hoặc thư giãn với nhiều mùi hương.'),
(3, 'Giỏ hoa', 'Giỏ mây, giỏ gỗ, giỏ tre dùng để cắm hoa.'),
(4, 'Thiệp chúc mừng', 'Thiệp handmade, thiệp sinh nhật, thiệp tình yêu.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(150) NOT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DiaChi` text DEFAULT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `SDT`, `Email`, `DiaChi`, `GhiChu`) VALUES
(1, 'Flower Farm Đà Lạt', '0263334567', 'dalat@flowerfarm.vn', 'Đà Lạt, Lâm Đồng', NULL),
(2, 'Nhà Vườn Phú Quốc', '0297356789', 'phuquoc@flower.vn', 'Phú Quốc, Kiên Giang', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `HoTen` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `MatKhau` varchar(255) DEFAULT NULL,
  `ChucVu` varchar(50) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen`, `Email`, `SDT`, `MatKhau`, `ChucVu`, `NgayTao`) VALUES
(1, 'Anh Kiệt', 'anhkiet@gmail.com', '123456', '$2y$10$.wPd6weQ.5gHZ4WUBCRQvO3UwdRszgaqn1I7mkEcsR5bq6euoTLAa', 'quan lý kho', '2025-10-20 12:22:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phukien`
--

CREATE TABLE `phukien` (
  `MaPhuKien` int(11) NOT NULL,
  `TenPhuKien` varchar(100) NOT NULL,
  `Gia` decimal(12,2) NOT NULL DEFAULT 0.00,
  `MoTa` text DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT 0,
  `TrangThai` varchar(50) DEFAULT 'Còn hàng',
  `MaLoaiPK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phukien`
--

INSERT INTO `phukien` (`MaPhuKien`, `TenPhuKien`, `Gia`, `MoTa`, `HinhAnh`, `SoLuong`, `TrangThai`, `MaLoaiPK`) VALUES
(1, 'Gấu Teddy trắng', 150000.00, 'Gấu bông mềm mịn, dễ thương tặng kèm hoa.', 'gau_teddy_trang.jpg', 20, 'Còn hàng', 1),
(2, 'Nến thơm Lavender', 70000.00, 'Nến hương oải hương giúp thư giãn, dễ chịu.', 'nen_lavender.jpg', 35, 'Còn hàng', 2),
(3, 'Giỏ hoa mây tre', 30000.00, 'Giỏ cắm hoa làm từ mây tự nhiên.', 'gio_may.jpg', 40, 'Còn hàng', 3),
(5, 'Thỏ yếm sunny', 180000.00, 'Chiều dài: 32cm Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)', 'phukien-16084_tho-yem-sunny-cm.jpg', 16, 'Còn hàng', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sukien`
--

CREATE TABLE `sukien` (
  `MaSK` int(11) NOT NULL,
  `TenSuKien` varchar(100) DEFAULT NULL,
  `NgayBatDau` date DEFAULT NULL,
  `NgayKetThuc` date DEFAULT NULL,
  `HieuUng` varchar(100) DEFAULT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `MaThanhToan` int(11) NOT NULL,
  `MaDon` int(11) DEFAULT NULL,
  `SoTien` decimal(12,2) DEFAULT NULL,
  `PhuongThuc` varchar(50) DEFAULT NULL,
  `NgayThanhToan` datetime DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `MaTB` int(11) NOT NULL,
  `TieuDe` varchar(200) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `NgayDang` datetime DEFAULT current_timestamp(),
  `TrangThai` varchar(50) DEFAULT 'Hiển thị'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongke`
--

CREATE TABLE `thongke` (
  `MaTK` int(11) NOT NULL,
  `Ngay` date DEFAULT NULL,
  `TongDoanhThu` decimal(15,2) DEFAULT NULL,
  `TongDonHang` int(11) DEFAULT NULL,
  `SanPhamBanChay` varchar(150) DEFAULT NULL,
  `SoLuongBan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thongke`
--

INSERT INTO `thongke` (`MaTK`, `Ngay`, `TongDoanhThu`, `TongDonHang`, `SanPhamBanChay`, `SoLuongBan`) VALUES
(1, '2025-10-18', 15000000.00, 35, 'Bó Hoa Hồng Đỏ Tình Yêu', 22),
(2, '2025-10-19', 13200000.00, 28, 'Bình Hoa Lan Tím Quý Phái', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tonkho`
--

CREATE TABLE `tonkho` (
  `MaTonKho` int(11) NOT NULL,
  `MaHoa` int(11) NOT NULL,
  `SoLuongNhap` int(11) DEFAULT 0,
  `SoLuongBan` int(11) DEFAULT 0,
  `SoLuongTon` int(11) GENERATED ALWAYS AS (`SoLuongNhap` - `SoLuongBan`) STORED,
  `NgayCapNhat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tonkho`
--

INSERT INTO `tonkho` (`MaTonKho`, `MaHoa`, `SoLuongNhap`, `SoLuongBan`, `NgayCapNhat`) VALUES
(1, 1, 50, 30, '2025-10-19 17:42:45'),
(2, 2, 40, 25, '2025-10-19 17:42:45'),
(3, 3, 20, 10, '2025-10-19 17:42:45'),
(4, 4, 35, 17, '2025-10-19 17:42:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `voucher`
--

CREATE TABLE `voucher` (
  `MaVoucher` int(11) NOT NULL,
  `MaKH` int(11) DEFAULT NULL,
  `MaCode` varchar(50) DEFAULT NULL,
  `GiaTriGiam` decimal(10,2) DEFAULT NULL,
  `NgayBatDau` date DEFAULT NULL,
  `NgayKetThuc` date DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `voucher`
--

INSERT INTO `voucher` (`MaVoucher`, `MaKH`, `MaCode`, `GiaTriGiam`, `NgayBatDau`, `NgayKetThuc`, `TrangThai`) VALUES
(1, 1, 'HOAYEU10', 10.00, '2025-10-01', '2025-12-31', 'Hoạt động'),
(2, NULL, 'WELCOME20', 20.00, '2025-10-01', '2025-12-31', 'Hoạt động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeuthich`
--

CREATE TABLE `yeuthich` (
  `MaKH` int(11) NOT NULL,
  `MaHoa` int(11) NOT NULL,
  `NgayThem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `yeuthich`
--

INSERT INTO `yeuthich` (`MaKH`, `MaHoa`, `NgayThem`) VALUES
(1, 3, '2025-10-19 17:42:28'),
(2, 1, '2025-10-19 17:42:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`MaAdmin`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD PRIMARY KEY (`MaBV`);

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`MaBanner`);

--
-- Chỉ mục cho bảng `chatsupport`
--
ALTER TABLE `chatsupport`
  ADD PRIMARY KEY (`MaChat`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `chinhanh`
--
ALTER TABLE `chinhanh`
  ADD PRIMARY KEY (`MaCN`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDon`,`MaHoa`),
  ADD KEY `MaHoa` (`MaHoa`);

--
-- Chỉ mục cho bảng `chude`
--
ALTER TABLE `chude`
  ADD PRIMARY KEY (`MaChuDe`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`MaDG`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaHoa` (`MaHoa`);

--
-- Chỉ mục cho bảng `diachigiaohang`
--
ALTER TABLE `diachigiaohang`
  ADD PRIMARY KEY (`MaDiaChi`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDon`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGio`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `giohangchitiet`
--
ALTER TABLE `giohangchitiet`
  ADD PRIMARY KEY (`MaGio`,`MaSP`,`LoaiSanPham`);

--
-- Chỉ mục cho bảng `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD PRIMARY KEY (`MaHinh`),
  ADD KEY `MaHoa` (`MaHoa`);

--
-- Chỉ mục cho bảng `hoa`
--
ALTER TABLE `hoa`
  ADD PRIMARY KEY (`MaHoa`),
  ADD KEY `MaLoai` (`MaLoai`),
  ADD KEY `MaChuDe` (`MaChuDe`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  ADD PRIMARY KEY (`MaLH`);

--
-- Chỉ mục cho bảng `loaihoa`
--
ALTER TABLE `loaihoa`
  ADD PRIMARY KEY (`MaLoai`);

--
-- Chỉ mục cho bảng `loaiphukien`
--
ALTER TABLE `loaiphukien`
  ADD PRIMARY KEY (`MaLoaiPK`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `phukien`
--
ALTER TABLE `phukien`
  ADD PRIMARY KEY (`MaPhuKien`),
  ADD KEY `FK_MaLoaiPK` (`MaLoaiPK`);

--
-- Chỉ mục cho bảng `sukien`
--
ALTER TABLE `sukien`
  ADD PRIMARY KEY (`MaSK`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaThanhToan`),
  ADD KEY `MaDon` (`MaDon`);

--
-- Chỉ mục cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`MaTB`);

--
-- Chỉ mục cho bảng `thongke`
--
ALTER TABLE `thongke`
  ADD PRIMARY KEY (`MaTK`);

--
-- Chỉ mục cho bảng `tonkho`
--
ALTER TABLE `tonkho`
  ADD PRIMARY KEY (`MaTonKho`),
  ADD KEY `MaHoa` (`MaHoa`);

--
-- Chỉ mục cho bảng `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`MaVoucher`),
  ADD UNIQUE KEY `MaCode` (`MaCode`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Chỉ mục cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD PRIMARY KEY (`MaKH`,`MaHoa`),
  ADD KEY `MaHoa` (`MaHoa`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `MaAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  MODIFY `MaBV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `banner`
--
ALTER TABLE `banner`
  MODIFY `MaBanner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `chatsupport`
--
ALTER TABLE `chatsupport`
  MODIFY `MaChat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `chinhanh`
--
ALTER TABLE `chinhanh`
  MODIFY `MaCN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `chude`
--
ALTER TABLE `chude`
  MODIFY `MaChuDe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `MaDG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `diachigiaohang`
--
ALTER TABLE `diachigiaohang`
  MODIFY `MaDiaChi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `hinhanh`
--
ALTER TABLE `hinhanh`
  MODIFY `MaHinh` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hoa`
--
ALTER TABLE `hoa`
  MODIFY `MaHoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  MODIFY `MaLH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `loaihoa`
--
ALTER TABLE `loaihoa`
  MODIFY `MaLoai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `loaiphukien`
--
ALTER TABLE `loaiphukien`
  MODIFY `MaLoaiPK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `phukien`
--
ALTER TABLE `phukien`
  MODIFY `MaPhuKien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `sukien`
--
ALTER TABLE `sukien`
  MODIFY `MaSK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `MaThanhToan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `MaTB` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thongke`
--
ALTER TABLE `thongke`
  MODIFY `MaTK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tonkho`
--
ALTER TABLE `tonkho`
  MODIFY `MaTonKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `voucher`
--
ALTER TABLE `voucher`
  MODIFY `MaVoucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chatsupport`
--
ALTER TABLE `chatsupport`
  ADD CONSTRAINT `chatsupport_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDon`) REFERENCES `donhang` (`MaDon`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaHoa`) REFERENCES `hoa` (`MaHoa`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`MaHoa`) REFERENCES `hoa` (`MaHoa`);

--
-- Các ràng buộc cho bảng `diachigiaohang`
--
ALTER TABLE `diachigiaohang`
  ADD CONSTRAINT `diachigiaohang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `giohangchitiet`
--
ALTER TABLE `giohangchitiet`
  ADD CONSTRAINT `fk_gio` FOREIGN KEY (`MaGio`) REFERENCES `giohang` (`MaGio`) ON DELETE CASCADE,
  ADD CONSTRAINT `giohangchitiet_ibfk_1` FOREIGN KEY (`MaGio`) REFERENCES `giohang` (`MaGio`);

--
-- Các ràng buộc cho bảng `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD CONSTRAINT `hinhanh_ibfk_1` FOREIGN KEY (`MaHoa`) REFERENCES `hoa` (`MaHoa`);

--
-- Các ràng buộc cho bảng `hoa`
--
ALTER TABLE `hoa`
  ADD CONSTRAINT `hoa_ibfk_1` FOREIGN KEY (`MaLoai`) REFERENCES `loaihoa` (`MaLoai`) ON DELETE SET NULL,
  ADD CONSTRAINT `hoa_ibfk_2` FOREIGN KEY (`MaChuDe`) REFERENCES `chude` (`MaChuDe`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `phukien`
--
ALTER TABLE `phukien`
  ADD CONSTRAINT `FK_LoaiPhuKien` FOREIGN KEY (`MaLoaiPK`) REFERENCES `loaiphukien` (`MaLoaiPK`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`MaDon`) REFERENCES `donhang` (`MaDon`);

--
-- Các ràng buộc cho bảng `tonkho`
--
ALTER TABLE `tonkho`
  ADD CONSTRAINT `tonkho_ibfk_1` FOREIGN KEY (`MaHoa`) REFERENCES `hoa` (`MaHoa`);

--
-- Các ràng buộc cho bảng `voucher`
--
ALTER TABLE `voucher`
  ADD CONSTRAINT `voucher_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD CONSTRAINT `yeuthich_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `yeuthich_ibfk_2` FOREIGN KEY (`MaHoa`) REFERENCES `hoa` (`MaHoa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
