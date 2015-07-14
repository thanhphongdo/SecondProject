-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mar 14 Avril 2015 à 17:36
-- Version du serveur: 5.6.11
-- Version de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `khosach`
--
CREATE DATABASE IF NOT EXISTS `khosach` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `khosach`;

-- --------------------------------------------------------

--
-- Structure de la table `chitietdonhang`
--

CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `MaDonHang` int(11) NOT NULL DEFAULT '0',
  `MaSach` int(11) NOT NULL DEFAULT '0',
  `SoLuong` int(11) NOT NULL,
  PRIMARY KEY (`MaDonHang`,`MaSach`),
  KEY `FK_ChiTietDonHang_DonHang` (`MaDonHang`),
  KEY `FK_ChiTietDonHang_SanPham` (`MaSach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDonHang`, `MaSach`, `SoLuong`) VALUES
(241, 5, 2),
(241, 6, 1),
(241, 7, 1),
(241, 64, 1),
(242, 5, 1),
(243, 5, 1),
(244, 6, 5),
(244, 63, 3),
(245, 6, 1),
(245, 64, 1),
(246, 6, 1),
(246, 63, 1),
(247, 7, 1),
(248, 41, 1),
(248, 76, 1),
(249, 5, 1),
(250, 61, 1),
(250, 64, 1);

-- --------------------------------------------------------

--
-- Structure de la table `donhang`
--

CREATE TABLE IF NOT EXISTS `donhang` (
  `MaDonHang` int(11) NOT NULL AUTO_INCREMENT,
  `TaiKhoan` varchar(30) DEFAULT NULL,
  `NgayDH` datetime NOT NULL,
  `NgayGH` datetime NOT NULL,
  `TrangThai` tinyint(1) NOT NULL,
  `TongTien` int(11) NOT NULL,
  `TongTrongLuong` float NOT NULL,
  `PhiVanChuyen` float NOT NULL,
  PRIMARY KEY (`MaDonHang`),
  KEY `PK_DonHang_ThanhVien` (`TaiKhoan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;

--
-- Contenu de la table `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `TaiKhoan`, `NgayDH`, `NgayGH`, `TrangThai`, `TongTien`, `TongTrongLuong`, `PhiVanChuyen`) VALUES
(241, 'PHONGDO', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 394000, 1752, 17520),
(242, 'PHONGDO', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 62000, 290, 2900),
(243, 'PHONGDO', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 62000, 290, 2900),
(244, 'PHONGDO', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 966000, 4248, 42480),
(245, 'PHONGDO', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 203000, 972, 9720),
(246, 'DUNGUYEN', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 250000, 1076, 10760),
(247, 'DUNGUYEN', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 67000, 200, 2000),
(248, 'DUNGUYEN', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 1, 295000, 1330, 13300),
(249, 'PHONG', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 1, 62000, 290, 2900),
(250, 'PHONG', '2015-04-14 00:00:00', '2015-04-29 00:00:00', 0, 117000, 592, 5920);

-- --------------------------------------------------------

--
-- Structure de la table `gopy`
--

CREATE TABLE IF NOT EXISTS `gopy` (
  `MaGopY` int(11) NOT NULL AUTO_INCREMENT,
  `TaiKhoan` varchar(30) DEFAULT NULL,
  `TieuDe` varchar(50) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayGui` date NOT NULL,
  PRIMARY KEY (`MaGopY`),
  KEY `FK_GopY_ThanhVien` (`TaiKhoan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `gopy`
--

INSERT INTO `gopy` (`MaGopY`, `TaiKhoan`, `TieuDe`, `NoiDung`, `NgayGui`) VALUES
(1, 'PHONGDO', 'Sach rach', 'bi rach con dem ban, lu khon nan', '2015-04-09');

-- --------------------------------------------------------

--
-- Structure de la table `khoangtrongluong`
--

CREATE TABLE IF NOT EXISTS `khoangtrongluong` (
  `MaKhoangTrongLuong` int(11) NOT NULL AUTO_INCREMENT,
  `TuTrongLuong` float NOT NULL DEFAULT '0',
  `DenTrongLuong` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`MaKhoangTrongLuong`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `khoangtrongluong`
--

INSERT INTO `khoangtrongluong` (`MaKhoangTrongLuong`, `TuTrongLuong`, `DenTrongLuong`) VALUES
(1, 0, 50),
(2, 50, 100),
(3, 100, 250),
(4, 250, 500),
(5, 500, 1000),
(6, 1000, 1500),
(7, 1500, 2000),
(8, 2000, 0);

-- --------------------------------------------------------

--
-- Structure de la table `khuvuc`
--

CREATE TABLE IF NOT EXISTS `khuvuc` (
  `MaKhuVuc` int(11) NOT NULL AUTO_INCREMENT,
  `TenKhuVuc` varchar(50) NOT NULL,
  PRIMARY KEY (`MaKhuVuc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `khuvuc`
--

INSERT INTO `khuvuc` (`MaKhuVuc`, `TenKhuVuc`) VALUES
(1, 'Äang cáº­p nháº­t'),
(2, 'Khu vá»±c miá»…n phÃ­ váº­n chuyá»ƒn'),
(3, 'Khu vá»±c thu phÃ­ má»©c 1'),
(4, 'Khu vá»±c thu phÃ­ má»©c 2'),
(5, 'Khu vá»±c thu phÃ­ má»©c 3');

-- --------------------------------------------------------

--
-- Structure de la table `nhaxuatban`
--

CREATE TABLE IF NOT EXISTS `nhaxuatban` (
  `MaNhaXuatBan` int(11) NOT NULL AUTO_INCREMENT,
  `TenNhaXuatBan` varchar(50) NOT NULL,
  `DiaChi` varchar(200) NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  PRIMARY KEY (`MaNhaXuatBan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `nhaxuatban`
--

INSERT INTO `nhaxuatban` (`MaNhaXuatBan`, `TenNhaXuatBan`, `DiaChi`, `SoDienThoai`, `Email`) VALUES
(1, 'Tá»•ng Há»£p TP.HCM', 'Quáº­n 1 TP.HCM', '0198365211', 'TongHopTPHCM@gmail.com'),
(2, 'Tráº»', 'Quáº­n 2 TP.HCM', '+8490124568', 'nhasachTre@gmail.com'),
(3, 'VÄƒn Há»c', 'BÃ¬nh Thá»§y-Cáº§n ThÆ¡', '0708913580', 'vanhoc@gmail.com'),
(4, 'VÄƒn HÃ³a - ThÃ´ng Tin', 'Quáº­n 3 TP.HCM', '0918359115', 'vhtt111@gmail.com'),
(5, 'Thanh NiÃªn', 'BÃ¬nh ChÃ¡nh-TP.HCM', '0790123678', 'thanhnien@gmail.com'),
(6, 'Kim Äá»“ng', 'Quáº­n 7 TP.HCM', '09035671234', 'kimdongns@gmail.com'),
(7, 'Phá»¥ Ná»¯', 'Ninh Kiá»u-Cáº§n ThÆ¡', '0123565757', 'phunuthoinay@gmail.com'),
(8, 'ThÃ´ng Táº¥n', 'HÃ ng Giáº¥y-HÃ  Ná»™i', '0159320541', 'thongtanxa@gmail.com.vn'),
(9, 'CÃ´ng An NhÃ¢n DÃ¢n', 'CÃ´ng An ThÃ nh Phá»‘ HCM', '071234567', 'congannhandan@gmail.com.vn'),
(10, 'Thá»i Äáº¡i', 'Quáº­n 5 TP.HCM', '021453894', 'thoidai@gmail.com'),
(11, 'Há»™i NhÃ  VÄƒn', 'Há»™i NhÃ  VÄƒn ThÃ nh Phá»‘ Há»“ ChÃ­ Minh', '0912398766', 'hoinhavantphcm@gamil.com'),
(12, 'VÄƒn HÃ³a SÃ i GÃ²n', 'Trung TÃ¢m VÄƒn HÃ³a SÃ i GÃ²n', '072345890', 'vanhoasaigon@gmail.com'),
(13, 'HÃ  Ná»™i', 'HÃ ng Äá»“ng-HÃ  Ná»™i', '0990345987', 'hanoi@gmail.com'),
(14, 'ÄÃ  Náºµng', 'PhÆ°á»ng 1 ÄÃ  Náºµng', '074678901', 'sachdanang@gamil.com'),
(15, 'VÄƒn HÃ³a -VÄƒn Nghá»‡', 'Quáº­n 2 TP.HCM', '0128903251', 'vanhoavannghe@gmail.com'),
(16, 'BÃ¡ch Khoa - HÃ  Ná»™i', 'HÃ ng Äá»“ng-HÃ  Ná»™i', '01756390', 'bachkhoahanoi@gmail.com'),
(17, 'TÃ i ChÃ­nh', 'PhÆ°á»ng 1 VÄ©nh Long', '0703567191', 'taichinh@gmail.com'),
(18, 'XÃ¢y Dá»±ng', 'P1 Ninh Kiá»u Cáº§n ThÆ¡', '070123098', 'xaydung@gmail.com'),
(19, 'Giao ThÃ´ng Váº­n Táº£i', '91B Cáº§n ThÆ¡', '07234578', 'giaothongvantaict@gmail.com'),
(20, 'Lao Äá»™ng XÃ£ Há»™i', '22P2 Tiá»n Giang', '+84129341789', 'ldxh@gmail.com'),
(21, 'Há»“ng Äá»©c', 'Ninh Kiá»u Cáº§n ThÆ¡', '01703469', 'hongduchd@gmail.com'),
(22, 'ChÃ­nh Trá»‹ Quá»‘c Gia', '23 Quáº­n 7 Tp.HCM', '085852719', 'chinhtriquocgia@gmail.com.vn'),
(23, 'Tháº¿ Giá»›i', '12 Quáº­n 1 Tp.HCM', '05678912', 'thegioi@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `phivanchuyen`
--

CREATE TABLE IF NOT EXISTS `phivanchuyen` (
  `MaKhuVuc` int(11) NOT NULL,
  `MaKhoangTrongLuong` int(11) NOT NULL,
  `PhiVanChuyen` int(11) NOT NULL,
  PRIMARY KEY (`MaKhuVuc`,`MaKhoangTrongLuong`),
  KEY `FK_PhiVanChuyen_KhuVuc` (`MaKhuVuc`),
  KEY `FK_PhiVanChuyen_KhoangTrongLuong` (`MaKhoangTrongLuong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `phivanchuyen`
--

INSERT INTO `phivanchuyen` (`MaKhuVuc`, `MaKhoangTrongLuong`, `PhiVanChuyen`) VALUES
(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(1, 8, 0),
(2, 1, 9724),
(2, 2, 14300),
(2, 3, 18876),
(2, 4, 26884),
(2, 5, 37752),
(2, 6, 45760),
(2, 7, 55484),
(2, 8, 4347),
(3, 1, 10868),
(3, 2, 15444),
(3, 3, 23738),
(3, 4, 31174),
(3, 5, 45188),
(3, 6, 58344),
(3, 7, 70356),
(3, 8, 9724),
(4, 1, 11440),
(4, 2, 16016),
(4, 3, 25740),
(4, 4, 33748),
(4, 5, 49764),
(4, 6, 63492),
(4, 7, 77220),
(4, 8, 10868);

-- --------------------------------------------------------

--
-- Structure de la table `quantri`
--

CREATE TABLE IF NOT EXISTS `quantri` (
  `TaiKhoan` varchar(30) NOT NULL DEFAULT '',
  `MatKhau` varchar(40) NOT NULL,
  PRIMARY KEY (`TaiKhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `quantri`
--

INSERT INTO `quantri` (`TaiKhoan`, `MatKhau`) VALUES
('PHONGDO', '827ccb0eea8a706c4c34a16891f84e7b'),
('quantri', '76d80224611fc919a5d54f0ff9fba446');

-- --------------------------------------------------------

--
-- Structure de la table `sach`
--

CREATE TABLE IF NOT EXISTS `sach` (
  `MaSach` int(11) NOT NULL AUTO_INCREMENT,
  `TenSach` varchar(200) DEFAULT NULL,
  `MaTheLoai` int(11) DEFAULT NULL,
  `MaTacGia` int(11) DEFAULT NULL,
  `MaNhaXuatBan` int(11) DEFAULT NULL,
  `NgayXuatBan` date NOT NULL,
  `KichThuoc` varchar(10) NOT NULL,
  `TrongLuong` float NOT NULL,
  `GiaBia` int(11) NOT NULL,
  `SoLuongTon` int(11) NOT NULL,
  `Hinh` varchar(200) NOT NULL,
  `TomTat` text,
  `LuotXem` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MaSach`),
  KEY `FK_Sach_TheLoaiSach` (`MaTheLoai`),
  KEY `FK_Sach_TacGia` (`MaTacGia`),
  KEY `FK_Sach_NhaXuatBan` (`MaNhaXuatBan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- Contenu de la table `sach`
--

INSERT INTO `sach` (`MaSach`, `TenSach`, `MaTheLoai`, `MaTacGia`, `MaNhaXuatBan`, `NgayXuatBan`, `KichThuoc`, `TrongLuong`, `GiaBia`, `SoLuongTon`, `Hinh`, `TomTat`, `LuotXem`) VALUES
(1, 'CÃ¡nh chim kiÃªu hÃ£nh', 13, 1, 1, '2014-04-01', '13 x 20.5', 180, 45000, 0, 'images/ao.gif.jpg', '', 11),
(3, 'Náº¿u khÃ´ng pháº£i lÃ  anh', 13, 3, 3, '2014-04-01', '13 x 20.5', 320, 79000, 293, 'images/neu_khong_phai_la_anh_nho.jpg', '', 6),
(4, 'Ngá»±a thÃ©p', 13, 4, 2, '2014-04-01', '13 x 20', 440, 95000, 0, 'images/ngua_thep_nho.jpg', '', 7),
(5, 'ThÃ nh phá»‘ bá»‹ kÃ©t Ã¡n biáº¿n máº¥t', 13, 5, 4, '2014-04-01', '13.5 x 20.', 290, 62000, 282, 'images/thanh_pho_bi_ket_an_bien_mat_nho.jpg', '', 11),
(6, 'BÆ°á»›c ra tá»« tháº§m láº·ng', 14, 6, 1, '2014-04-01', '14.5 X 20.', 510, 108000, 306, 'images/buoc_ra_tu_tham_lang_nho.jpg', '', 10),
(7, 'DÃ²ng sÃ´ng thÆ¡ áº¥u', 14, 7, 5, '2014-04-01', '13 x 20', 200, 67000, 234, 'images/dong_song_tho_au_nho.jpg', '', 7),
(8, 'Gia Ä‘Ã¬nh lung linh', 14, 6, 3, '2014-04-01', '13.5 x 20.', 190, 52000, 185, 'images/gia_dinh_lung_linh_nho.jpg', '', 0),
(9, 'Há» Ä‘Ã£ tháº¥y báº§u trá»i rá»™ng lá»›n', 14, 8, 2, '2014-04-01', '13 x 20', 310, 87000, 347, 'images/ho_da_thay_bau_troi_rong_lon_nho.jpg', '', 1),
(10, 'Tháº¿ giá»›i Máº¡ng vÃ  TÃ´i', 14, 9, 3, '2014-04-01', '13 x 20.5', 230, 55000, 219, 'images/the_gioi_mang_va_toi_nho.jpg', '', 1),
(11, 'An DÆ°Æ¡ng VÆ°Æ¡ng xÃ¢y thÃ nh á»‘c', 15, 10, 6, '2010-08-01', '14 x 22', 120, 20000, 78, 'images/an_duong_vuong_xay_thanh_oc_nho.jpg', '', 0),
(12, 'An TÆ°', 15, 10, 6, '2010-05-01', '14 x 22.5', 160, 26000, 151, 'images/an_tu_nho.jpg', '', 0),
(13, 'Con Ä‘Æ°á»ng háº§m trÃªn Ä‘á»“i A1', 15, 11, 6, '2009-05-01', '18.5 x 18.', 110, 11000, 60, 'images/con_duong_ham_tren_doi_a1_nho.jpg', '', 0),
(14, 'Giai thoáº¡i vá» tÃ i lÃ m cÃ¢u Ä‘á»‘i cá»§a vua LÃª ThÃ¡nh TÃ´ng', 15, 12, 5, '2004-12-01', '14 x 20', 40, 5000, 24, 'images/giai_thoai_ve_tai_lam_cau_doi_cua_vua_le_thanh_tong_nho.jpg', '', 0),
(15, 'HoÃ ng LÃª Nháº¥t Thá»‘ng ChÃ­', 15, 13, 3, '2010-01-01', '13.5 x 20.', 340, 60000, 397, 'images/hoang_le_nhat_thong_chi_nho.jpg', '', 0),
(16, 'Chiáº¿c gÆ°Æ¡ng Ä‘á»“ng', 16, 14, 7, '2010-10-01', '13 x 20.5', 270, 40000, 245, 'images/chiec_guong_dong_nho.jpg', '', 0),
(17, 'Chiáº¿n thuáº­t vÃ²ng trÃ²n ma quÃ¡i', 16, 15, 5, '2009-11-01', '14 x 20', 220, 40000, 235, 'images/chien_thuat_vong_tron_ma_quai_nho.jpg', '', 0),
(18, 'Láº­t láº¡i nhá»¯ng trang há»“ sÆ¡ máº­t sá»± tháº­t kinh hoÃ ng', 16, 14, 8, '2009-01-01', '14.5 x 20.', 270, 40000, 245, 'images/lat_lai_nhung_trang_ho_so_mat_su_that_kinh_hoang_nho.jpg', '', 0),
(19, 'Tráº¡i hoa Ä‘á»', 16, 14, 9, '2010-01-01', '13.5 x 21', 570, 92000, 575, 'images/trai_hoa_do_nho.jpg', '', 0),
(20, 'Truyá»‡n khÃ´ng nÃªn Ä‘á»c lÃºc giao thá»«a', 16, 16, 10, '2010-07-01', '14.5 x 20.', 740, 105000, 847, 'images/truyen_khong_nen_doc_luc_giao_thua_nho.jpg', '', 0),
(21, 'Ca dao vá» HÃ  Ná»™i', 17, 17, 3, '2009-04-01', '13 x 20.5', 200, 42000, 251, 'images/ca_dao_ve_ha_noi_nho.jpg', '', 0),
(22, 'Cháº¥m', 17, 18, 11, '2013-09-01', '15 x 23', 200, 70000, 180, 'images/cham_nho.jpg', '', 0),
(23, 'Äá»‘ Kiá»u nÃ©t Ä‘áº¹p vÄƒn hÃ³a', 17, 19, 12, '2007-01-01', '14.5 x 20.', 280, 30000, 256, 'images/do_kieu_net_dep_van_hoa_nho.jpg', '', 0),
(24, 'Thi nhÃ¢n Viá»‡t Nam', 17, 20, 3, '2006-01-01', '13 x 19', 300, 36000, 415, 'images/thi_nhan_viet_nam_nho.jpg', '', 0),
(25, 'Truyá»‡n Kiá»u thÆ¡ vÃ  tranh', 17, 21, 3, '2010-07-01', '22 x 28.5', 228, 220000, 228, 'images/truyen_kieu_tho_va_tranh_nho.jpg', '', 0),
(26, 'Con chim khÃ¡t tá»•', 9, 22, 2, '2014-03-01', '13 x 20', 550, 172000, 667, 'images/con_chim_khat_to_nho.jpg', '', 0),
(27, 'ÄÃ¢u chá»‰ mÃ¬nh anh', 9, 23, 13, '2010-10-01', '14 x 20.5', 510, 86000, 477, 'images/dau_chi_minh_anh_nho.jpg', '', 0),
(28, 'Háº¡t Higgs - Con ÄÆ°á»ng PhÃ¡t Minh VÃ  KhÃ¡m PhÃ¡ "Háº¡t Cá»§a ChÃºa"', 9, 24, 2, '2014-04-01', '14 x 20', 310, 112000, 281, 'images/hat_higgs_con_duong_phat_minh_va_kham_pha_hat_cua_chua_nho.jpg', '', 0),
(29, 'Há»“i á»©c cá»§a má»™t Geisha', 9, 25, 3, '2014-04-01', '13 x 19', 590, 99000, 749, 'images/hoi_uc_cua_mot_geisha_nho.jpg', '', 0),
(30, 'TÃ¬nh yÃªu chÃ¢n chÃ­nh', 9, 26, 3, '2011-01-01', '13 x 21', 490, 89000, 491, 'images/tinh_yeu_chan_chinh_nho.jpg', '', 0),
(31, 'Biá»ƒu tÆ°á»£ng tháº¥t truyá»n', 10, 27, 10, '2014-04-01', '16 x 24', 850, 169000, 744, 'images/bieu_tuong_that_truyen_nho.jpg', '', 0),
(32, 'Há»a ngá»¥c', 10, 27, 10, '2014-03-01', '16 x 24', 820, 185000, 720, 'images/hoa_nguc_nho.jpg', '', 1),
(33, 'Khi lá»—i thuá»‘c vá» nhá»¯ng vÃ¬ sao', 10, 28, 2, '2014-04-01', '13 x 20', 320, 105000, 360, 'images/khi_loi_thuoc_ve_nhung_vi_sao_nho.jpg', '', 0),
(34, 'Má»‘i tÃ¬nh 2D', 10, 29, 7, '2014-04-01', '15.5 x 23.', 410, 94000, 350, 'images/moi_tinh_2d_nho.jpg', '', 0),
(35, 'NÆ¡i ngáº­p trÃ n tÃ¬nh yÃªu', 10, 30, 7, '2014-04-01', '13.5 x 20.', 340, 105000, 419, 'images/noi_ngap_tran_tinh_yeu_nho.jpg', '', 0),
(36, 'BÃ­ máº­t cá»§a Naoko', 11, 31, 10, '2011-01-01', '14 x 20.5', 500, 85000, 464, 'images/bi_mat_cua_naoko_nho.jpg', '', 0),
(37, 'Äom Äom', 11, 32, 14, '2006-09-01', '13 x 20.5', 340, 40000, 356, 'images/dom_dom_nho.jpg', '', 0),
(38, 'Kafka trÃªn bá» biá»ƒn', 11, 32, 5, '2011-09-01', '15.5 x 24', 710, 95000, 540, 'images/kafka_tren_bo_bien_nho.jpg', '', 0),
(39, 'MÃ¹a thu cá»§a cÃ¢y dÆ°Æ¡ng', 11, 33, 15, '2010-10-01', '13 x 20.5', 220, 37000, 202, 'images/mua_thu_cua_cay_duong_nho.jpg', '', 0),
(40, 'Ná»¯ sinh', 11, 34, 11, '2014-02-01', '13 x 19', 150, 47000, 177, 'images/nu_sinh_nho.jpg', '', 0),
(41, 'Bá»‡nh tÃ¬nh yÃªu', 12, 35, 1, '2014-04-01', '16 x 24', 610, 115000, 508, 'images/benh_tinh_yeu_nho.jpg', '', 0),
(42, 'Máº¹ thÆ¡m má»™t cÃ¡i', 12, 36, 10, '2014-04-01', '14 x 20.5', 290, 70000, 253, 'images/me_thom_mot_cai_nho.jpg', '', 0),
(43, 'Náº¿u anh nÃ³i anh yÃªu em', 12, 37, 9, '2014-04-01', '15.5 x 23.', 600, 109000, 433, 'images/neu_anh_noi_anh_yeu_em_nho.jpg', '', 0),
(44, 'Tiá»ƒu thÆ° bÃ¬nh tÄ©nh', 12, 38, 3, '2014-04-01', '14.5 x 20.', 400, 139000, 456, 'images/tieu_thu_binh_tinh_nho.jpg', '', 0),
(45, 'YÃªu láº¡i tá»« Ä‘áº§u', 12, 39, 1, '2014-04-01', '16 x 24', 360, 75000, 20, 'images/yeu_lai_tu_dau_nho.jpg', '', 0),
(46, 'ÄÃ´rÃªmon chiáº¿n tháº¯ng quÄ© Kamat', 7, 40, 6, '2009-04-01', '11.3 x 17.', 140, 13000, 190, 'images/doremon_chien_thang_qui_kamat_nho.jpg', '', 0),
(47, 'ÄÃ´rÃªmon lÃ¢u Ä‘Ã i dÆ°á»›i Ä‘Ã¡y biá»ƒn', 7, 40, 6, '2009-04-01', '11.3 x 17.', 140, 13000, 208, 'images/doremon_lau_dai_duoi_day_bien_nho.jpg', '', 1),
(48, 'ÄÃ´rÃªmon ngÃ´i sao cáº£m', 7, 40, 6, '2009-04-01', '11.3 x 17.', 140, 13000, 189, 'images/doremon_ngoi_sao_cam_nho.jpg', '', 0),
(49, 'ÄÃ´rÃªmon tÃªn Ä‘á»™c tÃ i vÅ© trá»¥', 7, 40, 6, '2009-04-01', '11.3 x 17.', 140, 13000, 188, 'images/doremon_ten_doc_tai_vu_tru_nho.jpg', '', 0),
(50, 'ÄÃ´rÃªmon VÆ°Æ¡ng quá»‘c trÃªn mÃ¢y', 7, 40, 6, '2009-04-01', '11.3 x 17.', 150, 13000, 189, 'images/doremon_vuong_quoc_tren_may_nho.jpg', '', 0),
(51, 'ThÃ¡m tá»­ lá»«ng danh Conan táº­p 20', 8, 41, 6, '2009-11-01', '11.3 x 17.', 130, 13000, 214, 'images/tham_tu_lung_danh_conan_tap_20_nho.jpg', '', 0),
(52, 'ThÃ¡m tá»­ lá»«ng danh Conan táº­p 27', 8, 41, 6, '2009-11-01', '11.3 x 17.', 130, 13000, 214, 'images/tham_tu_lung_danh_conan_tap_27_nho.jpg', '', 0),
(53, 'ThÃ¡m tá»­ lá»«ng danh Conan táº­p 29', 8, 41, 6, '2009-11-01', '11.3 x 17.', 130, 13000, 214, 'images/tham_tu_lung_danh_conan_tap_29_nho.jpg', '', 0),
(54, 'ThÃ¡m tá»­ lá»«ng danh Conan táº­p 35', 8, 41, 6, '2009-11-01', '11.3 x 17.', 130, 13000, 214, 'images/tham_tu_lung_danh_conan_tap_35_nho.jpg', '', 0),
(55, 'ThÃ¡m tá»­ lá»«ng danh Conan táº­p 38', 8, 41, 6, '2009-11-01', '11.3 x 17.', 130, 13000, 214, 'images/tham_tu_lung_danh_conan_tap_38_nho.jpg', '', 0),
(56, 'BÃ i táº­p hÃ³a há»c Ä‘áº¡i cÆ°Æ¡ng', 1, 42, 16, '2010-07-01', '19 x 27', 280, 62500, 171, 'images/bai_tap_hoa_hoc_dai_cuong_nho.jpg', '', 0),
(57, 'HÃ³a há»c Ä‘áº¡i cÆ°Æ¡ng', 1, 42, 16, '2010-07-01', '19 x 27', 290, 62000, 166, 'images/hoa_hoc_dai_cuong_nho.jpg', '', 0),
(58, 'Quáº£n trá»‹ cháº¥t lÆ°á»£ng', 1, 43, 17, '2010-07-01', '16 x 24', 660, 105000, 460, 'images/quan_tri_chat_luong_nho.jpg', '', 0),
(59, 'Thiáº¿t káº¿ há»‡ thá»‘ng tÆ°á»›i tiÃªu', 1, 43, 18, '2006-06-01', '19 x 27', 730, 85000, 482, 'images/thiet_ke_he_thong_tuoi_tieu_nho.jpg', '', 0),
(60, 'Thá»‘ng kÃª kinh doanh quáº£n lÃ­', 1, 44, 19, '2010-07-01', '16 x 24', 510, 108000, 430, 'images/thong_ke_kinh_doanh_quan_li_nho.jpg', '', 0),
(61, 'BÃ¡o chÃ­ tháº¿ giá»›i - xu hÆ°á»›ng phÃ¡t triá»ƒn', 2, 46, 8, '2008-04-01', '13 x 19', 130, 22000, 166, 'images/bao_chi_the_gioi_xu_huong_phat_trien_nho.jpg', '', 0),
(62, 'Báº­t má»™t que diÃªm', 2, 47, 2, '2009-06-01', '13 x 20.5', 360, 58000, 360, 'images/bat_mot_que_diem_nho.jpg', '', 0),
(63, 'Lá»i tá»± thÃº cá»§a nhÃ  bÃ¡o Má»¹', 2, 48, 2, '2010-04-01', '14.5 x 20.', 566, 142000, 562, 'images/loi_tu_thu_cua_nha_bao_my_nho.jpg', '', 0),
(64, 'NhÃ  bÃ¡o hiá»‡n Ä‘áº¡i', 2, 49, 2, '2007-08-01', '16 x 24', 462, 95000, 459, 'images/nha_bao_hien_dai_nho.jpg', '', 2),
(65, 'C# 2005 láº­p trÃ¬nh cÆ¡ báº£n', 3, 50, 20, '2008-07-01', '16 x 24', 490, 98000, 432, 'images/c_sharp_2005_lap_trinh_co_ban_nho.jpg', '', 0),
(66, 'Chinh phá»¥c photoshop cs2', 3, 51, 19, '2006-07-01', '14.5 x 20.', 360, 55000, 404, 'images/chinh_phuc_photoshop_cs2_nho.jpg', '', 0),
(67, 'GiÃ¡o trÃ¬nh tá»± há»c láº­p trÃ¬nh visual basic 2008 táº­p 1', 3, 52, 21, '2008-10-01', '16 x 24', 350, 54000, 298, 'images/giao_trinh_tu_hoc_lap_trinh_can_ban_visual_basic_2008_tap_1_nho.jpg', '', 0),
(68, 'GiÃ¡o trÃ¬nh tá»± há»c láº­p trÃ¬nh visual basic 2008 táº­p 2', 3, 52, 21, '2010-10-01', '16 x 24', 320, 48000, 268, 'images/giao_trinh_tu_hoc_lap_trinh_can_ban_visual_basic_2008_tap_2_nho.jpg', '', 0),
(69, 'Tá»± há»c Flash', 3, 53, 20, '2006-08-01', '16 x 24', 320, 49000, 272, 'images/tu_hoc_flash_nho.jpg', '', 0),
(70, '9 báº£n tuyÃªn ngÃ´n ná»•i tiáº¿ng tháº¿ giá»›i', 4, 54, 4, '2006-01-01', '14.5 x 20.', 630, 80000, 619, 'images/9_ban_tuyen_ngon_noi_tieng_the_gioi_nho.jpg', '', 0),
(71, '36 láº¯ng nghe HÃ  Ná»™i', 4, 55, 5, '2010-01-01', '13 x 20.5', 120, 25000, 139, 'images/36_lang_nghe_ha_noi_nho.jpg', '', 0),
(72, 'Äiá»‡n BiÃªn Phá»§', 4, 56, 22, '2010-03-01', '15 x 22', 680, 95000, 474, 'images/dien_bien_phu_nho.jpg', '', 0),
(73, 'PhÃ­a sau cuá»™c chiáº¿n', 4, 57, 8, '2010-09-01', '14 x 20.5', 360, 65000, 337, 'images/phia_sau_cuoc_chien_nho.jpg', '', 0),
(74, 'Tá»« Hi ThÃ¡i Háº­u - giáº¥c má»™ng vÆ°Æ¡ng phi', 4, 58, 4, '2010-10-01', '16 x 24', 650, 126000, 607, 'images/tu_hi_thai_hau_giac_mong_vuong_phi_nho.jpg', '', 0),
(75, 'Viá»‡t Nam sá»­ lÆ°á»£c', 4, 59, 4, '2006-01-01', '14.5 x 20.', 760, 80000, 760, 'images/viet_nam_su_luoc_nho.jpg', '', 0),
(76, 'Cáº©m nang phÃ²ng trá»‹ ung thÆ°', 5, 60, 1, '2014-04-01', '14 x 20.5', 180, 45000, 142, 'images/cam_nang_phong_tri_ung_thu_nho.jpg', '', 0),
(77, 'Khá»e lÃªn tráº» láº¡i - Lá»¥c Äiá»‡u chÃ¢n kinh', 5, 61, 23, '2014-04-01', '14 x 20.5', 120, 38000, 102, 'images/khoe_len_tre_lai_luc_dieu_chan_kinh_nho.jpg', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `tacgia`
--

CREATE TABLE IF NOT EXISTS `tacgia` (
  `MaTacGia` int(11) NOT NULL AUTO_INCREMENT,
  `TenTacGia` varchar(50) NOT NULL,
  PRIMARY KEY (`MaTacGia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Contenu de la table `tacgia`
--

INSERT INTO `tacgia` (`MaTacGia`, `TenTacGia`) VALUES
(1, 'Äang cáº­p nháº­t'),
(2, 'Äá»— Thanh Phong'),
(3, 'DÆ°Æ¡ng Thá»¥y'),
(4, 'Tiá»ƒu Chi'),
(5, 'Pháº¡m Há»“n NhiÃªm'),
(6, 'Tráº§n Trá»ng VÅ©'),
(7, 'MÃ£ Thiá»‡n Äá»“ng'),
(8, 'SÃ¢m ThÆ°Æ¡ng'),
(9, 'Tráº§n Quá»‘c ToÃ n'),
(10, 'Nguyá»…n Thá»‹ Háº­u'),
(11, 'Nguyá»…n Huy TÆ°á»Ÿng'),
(12, 'Huy ToÃ n'),
(13, 'Máº¡nh TÃ¢m'),
(14, 'NgÃ´ Gia VÄƒn PhÃ¡i'),
(15, 'Dili'),
(16, 'Huá»³nh Ngá»c ChÃªnh'),
(17, 'LÆ°u SÆ¡n Minh'),
(18, 'BÃ­ch Háº±ng'),
(19, 'Nguyá»…n Ngá»c TÆ°'),
(20, 'Pháº¡m Äan Quáº¿'),
(21, 'HoÃ i Thanh'),
(22, 'Nguyá»…n Du'),
(23, 'Robert Galbraith'),
(24, 'Jane Green'),
(25, 'Jim Baggott'),
(26, 'Arthur Golden'),
(27, 'Danny Scheinmann'),
(28, 'Dan Brown'),
(29, 'John Green'),
(30, 'Jessica Park'),
(31, 'Billie Letts'),
(32, 'Higashino Keigo'),
(33, 'Haruki Murakami'),
(34, 'Kazumi Yumoto'),
(35, 'Dazai Osamu'),
(36, 'PhÆ°Æ¡ng Tranh'),
(37, 'Cá»­u Báº£ Äao'),
(38, 'Láº¡c HÃ '),
(39, 'Láº¡c Tiá»ƒu Tháº¥t'),
(40, 'Minh Nguyá»‡t Tha HÆ°Æ¡ng Chiáº¿u'),
(41, 'Yujiko.F.Fujio'),
(42, 'Aoyama Gosho'),
(43, 'Nguyá»…n Khanh'),
(44, 'Nguyá»…n Kim Äá»‹nh'),
(45, 'Nguyá»…n Anh Tuáº¥n'),
(46, 'Nguyá»…n VÄƒn Dung'),
(47, 'Äinh Thá»‹ ThÃºy Háº±ng'),
(48, 'LÆ°u ÄÃ¬nh Triá»u'),
(49, 'Tom Plate'),
(50, 'The Missouri Group'),
(51, 'Pháº¡m Há»¯u Khang'),
(52, 'Äáº­u Quang Tuáº¥n'),
(53, 'Nguyá»…n ÄÃ¬nh Nam'),
(54, 'Nguyá»…n TrÆ°á»ng Sinh'),
(55, 'Nguyá»…n VÄƒn Ãšt'),
(56, 'Quá»‘c VÄƒn'),
(57, 'VÃµ NguyÃªn GiÃ¡p'),
(58, 'Deborah Nelson'),
(59, 'Má»™ng BÃ¬nh SÆ¡n'),
(60, 'Tráº§n Trá»ng Kim'),
(61, 'Nguyá»…n Cháº¥n HÃ¹ng'),
(62, 'Huá»³nh Kim TÆ°á»›c');

-- --------------------------------------------------------

--
-- Structure de la table `thanhvien`
--

CREATE TABLE IF NOT EXISTS `thanhvien` (
  `TaiKhoan` varchar(30) NOT NULL DEFAULT '',
  `MatKhau` varchar(40) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` varchar(5) NOT NULL,
  `DiaChi` varchar(200) NOT NULL,
  `DienThoai` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Locked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`TaiKhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `thanhvien`
--

INSERT INTO `thanhvien` (`TaiKhoan`, `MatKhau`, `HoTen`, `NgaySinh`, `GioiTinh`, `DiaChi`, `DienThoai`, `Email`, `Locked`) VALUES
('DUNGUYEN', '202cb962ac59075b964b07152d234b70', 'DÆ° NguyÃªn', '1994-12-12', 'Nam', 'An Giang', '1233232', 'nguyen@gmail.com', 0),
('HOANGHUY', '81dc9bdb52d04dc20036dbd8313ed055', 'HoangHuy', '1994-12-12', 'Nam', 'An Giang', '32323232', 'huy@gmail.com', 0),
('PHONG', '698d51a19d8a121ce581499d7b701668', 'phong', '2015-04-18', 'Nam', 'AG', '1234567', 'phong@gmail.com', 0),
('PHONGDO', 'e10adc3949ba59abbe56e057f20f883e', 'Äá»— Thanh Phong', '1994-12-30', 'Nam', 'An Giang', '11111111111111', 'PhongDo@gmail', 0),
('THANHPHONG', '698d51a19d8a121ce581499d7b701668', 'Äá»— Thanh Phong', '2015-04-16', 'Nam', 'An Giang', '0123252617', 'PhongDo@gmail', 0),
('XUANHOANG', '250cf8b51c773f3f8dc8b4be867a9a02', 'XuanHoang', '1994-12-12', 'Nam', 'An Giang', '1212121', 'hoang@gmail.com', 0);

-- --------------------------------------------------------

--
-- Structure de la table `theloaisach`
--

CREATE TABLE IF NOT EXISTS `theloaisach` (
  `MaTheLoai` int(11) NOT NULL AUTO_INCREMENT,
  `TenTheLoai` varchar(50) NOT NULL,
  `TheLoaiCha` int(11) DEFAULT NULL,
  PRIMARY KEY (`MaTheLoai`),
  KEY `FK_TheLoaiSach_TheLoaiSach` (`TheLoaiCha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `theloaisach`
--

INSERT INTO `theloaisach` (`MaTheLoai`, `TenTheLoai`, `TheLoaiCha`) VALUES
(1, 'VÄƒn há»c Viá»‡t Nam', NULL),
(2, 'VÄƒn há»c nÆ°á»›c ngoÃ i', NULL),
(3, 'Truyá»‡n tranh - Manga', NULL),
(4, 'GiÃ¡o trÃ¬nh Äáº¡i há»c - Cao Ä‘áº³ng', NULL),
(5, 'SÃ¡ch chuyÃªn ngÃ nh', NULL),
(6, 'Tiá»ƒu thuyáº¿t', 1),
(7, 'Truyá»‡n ngáº¯n - táº¡p vÄƒn', 1),
(8, 'Truyá»‡n lá»‹ch sá»­', 1),
(9, 'Truyá»‡n trinh thÃ¡m - viá»…n tÆ°á»Ÿng', 1),
(10, 'ThÆ¡ - ca dao - tá»¥c ngá»¯', 1),
(11, 'VÄƒn há»c Anh', 2),
(12, 'VÄƒn há»c Má»¹', 2),
(13, 'VÄƒn Há»c Nháº­t', 2),
(14, 'VÄƒn Há»c Trung Quá»‘c', 2),
(15, 'ÄÃ´rÃªmon', 3),
(16, 'ThÃ¡m tá»­ lá»«ng danh Conan', 3),
(17, 'GiÃ¡o trÃ¬nh Äáº¡i há»c - Cao Ä‘áº³ng', 4),
(18, 'Nghiá»‡p vá»¥ bÃ¡o chÃ­', 4),
(19, 'CÃ´ng nghá»‡ thÃ´ng tin', 5),
(20, 'Lá»‹ch sá»­ - Ä‘á»‹a lÃ­', 5),
(21, 'Y dÆ°á»£c', 5);

-- --------------------------------------------------------

--
-- Structure de la table `tinhthanh`
--

CREATE TABLE IF NOT EXISTS `tinhthanh` (
  `MaTinhThanh` int(11) NOT NULL AUTO_INCREMENT,
  `TenTinhThanh` varchar(50) NOT NULL,
  `MaKhuVuc` int(11) DEFAULT NULL,
  PRIMARY KEY (`MaTinhThanh`),
  KEY `FK_TinhThanh_KhuVuc` (`MaKhuVuc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Contenu de la table `tinhthanh`
--

INSERT INTO `tinhthanh` (`MaTinhThanh`, `TenTinhThanh`, `MaKhuVuc`) VALUES
(1, 'An Giang', 2),
(2, 'BÃ¬nh DÆ°Æ¡ng', 2),
(3, 'BÃ¬nh PhÆ°á»›c', 2),
(4, 'BÃ  Rá»‹a - VÅ©ng TÃ u', 2),
(5, 'Báº¡c LiÃªu', 2),
(6, 'Báº¿n Tre', 2),
(7, 'TP.Há»“ ChÃ­ Minh', 2),
(8, 'BÃ¬nh Thuáº­n', 2),
(9, 'CÃ  Mau', 2),
(10, 'Cáº§n ThÆ¡', 1),
(11, 'Äá»“ng Nai', 2),
(12, 'Äá»“ng ThÃ¡p', 2),
(13, 'Háº­u Giang', 2),
(14, 'KiÃªn Giang', 2),
(15, 'Long An', 2),
(16, 'LÃ¢m Äá»“ng', 2),
(17, 'Ninh Thuáº­n', 2),
(18, 'SÃ³c TrÄƒng', 2),
(19, 'TÃ¢y Ninh', 2),
(20, 'Tiá»n Giang', 2),
(21, 'TrÃ  Vinh', 2),
(22, 'VÄ©nh Long', 2),
(23, 'Äáº¯k Láº¯k', 2),
(24, 'Äáº¯k NÃ´ng', 2),
(25, 'ÄÃ  Náºµng', 3),
(26, 'HÃ  Ná»™i', 3),
(27, 'BÃ¬nh Äá»‹nh', 4),
(28, 'Gia Lai', 4),
(29, 'Thá»«a ThiÃªn Huáº¿', 4),
(30, 'Kon Tum', 4),
(31, 'KhÃ¡nh HÃ²a', 4),
(32, 'PhÃº YÃªn', 4),
(33, 'Quáº£ng BÃ¬nh', 4),
(34, 'Quáº£ng Trá»‹', 4),
(35, 'Quáº£ng NgÃ£i', 4),
(36, 'Báº¯c Cáº¡n', 4),
(37, 'Báº¯c Giang', 4),
(38, 'Báº¯c Ninh', 4),
(39, 'Cao Báº±ng', 4),
(40, 'Äiá»‡n BiÃªn', 4),
(41, 'HÃ  Giang', 4),
(42, 'HÃ  Nam', 4),
(43, 'HÃ  TÄ©nh', 4),
(44, 'Háº£i DÆ°Æ¡ng', 4),
(45, 'Háº£i PhÃ²ng', 4),
(46, 'HÆ°ng YÃªn', 4),
(47, 'HÃ²a BÃ¬nh', 4),
(48, 'LÃ o Cai', 4),
(49, 'Lai ChÃ¢u', 4),
(50, 'Láº¡ng SÆ¡n', 4),
(51, 'Nam Äá»‹nh', 4),
(52, 'Nghá»‡ An', 4),
(53, 'Ninh BÃ¬nh', 4),
(54, 'PhÃº Thá»', 4),
(55, 'Quáº£ng Ninh', 4),
(56, 'SÆ¡n La', 4),
(57, 'ThÃ¡i BÃ¬nh', 4),
(58, 'ThÃ¡i NguyÃªn', 4),
(59, 'Thanh HÃ³a', 4),
(60, 'TuyÃªn Quang', 4),
(61, 'VÄ©nh PhÃºc', 4),
(62, 'YÃªn BÃ¡i', 4);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `FK_ChiTietDonHang_DonHang` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`),
  ADD CONSTRAINT `FK_ChiTietDonHang_Sach` FOREIGN KEY (`MaSach`) REFERENCES `sach` (`MaSach`);

--
-- Contraintes pour la table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `FK_DonHang_ThanhVien` FOREIGN KEY (`TaiKhoan`) REFERENCES `thanhvien` (`TaiKhoan`);

--
-- Contraintes pour la table `gopy`
--
ALTER TABLE `gopy`
  ADD CONSTRAINT `FK_GopY_ThanhVien` FOREIGN KEY (`TaiKhoan`) REFERENCES `thanhvien` (`TaiKhoan`);

--
-- Contraintes pour la table `phivanchuyen`
--
ALTER TABLE `phivanchuyen`
  ADD CONSTRAINT `FK_PhiVanChuyen_KhoangTrongLuong` FOREIGN KEY (`MaKhoangTrongLuong`) REFERENCES `khoangtrongluong` (`MaKhoangTrongLuong`),
  ADD CONSTRAINT `FK_PhiVanChuyen_KhuVuc` FOREIGN KEY (`MaKhuVuc`) REFERENCES `khuvuc` (`MaKhuVuc`);

--
-- Contraintes pour la table `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `FK_Sach_NhaXuatBan` FOREIGN KEY (`MaNhaXuatBan`) REFERENCES `nhaxuatban` (`MaNhaXuatBan`),
  ADD CONSTRAINT `FK_Sach_TacGia` FOREIGN KEY (`MaTacGia`) REFERENCES `tacgia` (`MaTacGia`),
  ADD CONSTRAINT `FK_Sach_TheLoaiSach` FOREIGN KEY (`MaTheLoai`) REFERENCES `theloaisach` (`MaTheLoai`);

--
-- Contraintes pour la table `theloaisach`
--
ALTER TABLE `theloaisach`
  ADD CONSTRAINT `FK_TheLoaiSach_TheLoaiSach` FOREIGN KEY (`TheLoaiCha`) REFERENCES `theloaisach` (`MaTheLoai`);

--
-- Contraintes pour la table `tinhthanh`
--
ALTER TABLE `tinhthanh`
  ADD CONSTRAINT `FK_TinhThanh_KhuVuc` FOREIGN KEY (`MaKhuVuc`) REFERENCES `khuvuc` (`MaKhuVuc`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
