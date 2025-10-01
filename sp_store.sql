-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Okt 01. 10:30
-- Kiszolgáló verziója: 10.4.18-MariaDB
-- PHP verzió: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `sp_store`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `attributes`
--

INSERT INTO `attributes` (`id`, `group_id`, `value`) VALUES
(1, 1, 'XL'),
(2, 1, 'XXL'),
(3, 2, 'Zöld'),
(4, 2, 'Kék');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `attribute_groups`
--

CREATE TABLE `attribute_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `attribute_groups`
--

INSERT INTO `attribute_groups` (`id`, `name`) VALUES
(1, 'Méret'),
(2, 'Szín');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `image_path`, `is_visible`) VALUES
(5, NULL, 'első', 'elso', '', 'public/uploads/categories/1758878637_68d65bad5b555_hambi.png', 1),
(6, NULL, 'sdgsdg', 'sdgsdg', '', 'public/uploads/categories/1758877314_68d65682c6c84_hambi.png', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `homepage_sections`
--

CREATE TABLE `homepage_sections` (
  `id` int(11) NOT NULL,
  `section_type` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `config` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `homepage_sections`
--

INSERT INTO `homepage_sections` (`id`, `section_type`, `title`, `config`, `sort_order`, `is_visible`) VALUES
(1, 'top_categories', 'top kategóriák', '{\"category_ids\":[\"5\"],\"limit\":\"3\"}', 1, 1),
(2, 'promo_banners', 'Promóciós bannerek', '{\"banners\":[{\"tag\":\"AKCI\\u00d3\",\"title\":\"Valami sz\\u00f6veg\",\"subtitle\":\"Ez itt egy alsz\\u00f6veg\",\"button_text\":\"Katt ide\",\"link\":\"#\",\"image_path\":\"uploads\\/1es.jpg\"},{\"tag\":\"AKCI\\u00d3 1\",\"title\":\"Valami sz\\u00f6veg 1\",\"subtitle\":\"Ez itt egy alsz\\u00f6veg 1\",\"button_text\":\"Katt ide\",\"link\":\"#\",\"image_path\":\"uploads\\/1es.jpg\"},{\"tag\":\"AKCI\\u00d3 11\",\"title\":\"Valami sz\\u00f6veg 11\",\"subtitle\":\"Ez itt egy alsz\\u00f6veg 11\",\"button_text\":\"Katt ide\",\"link\":\"#\",\"image_path\":\"uploads\\/1es.jpg\"}]}', 2, 1),
(3, 'trending_products', 'Legújabb termékeink', '{\"product_ids\":[\"9\"],\"limit\":\"1\"}', 3, 1),
(4, 'popular_items', 'Népszerű termékek', '{\"tabs\":[{\"category_id\":\"5\",\"title\":\"\"},{\"category_id\":\"\",\"title\":\"\"},{\"category_id\":\"\",\"title\":\"\"},{\"category_id\":\"\",\"title\":\"\"},{\"category_id\":\"\",\"title\":\"\"}],\"limit\":\"8\"}', 5, 1),
(5, 'info_bar', 'Információs sáv	', '{\"items\":[{\"icon\":\"truck\",\"title\":\"Ingyenes sz\\u00e1ll\\u00edt\\u00e1s\",\"subtitle\":\"20.000 Ft felett\"},{\"icon\":\"shield-check\",\"title\":\"Biztons\\u00e1gos fizet\\u00e9s\",\"subtitle\":\"\"},{\"icon\":\"percent\",\"title\":\"Valami\",\"subtitle\":\"\"},{\"icon\":\"\",\"title\":\"\",\"subtitle\":\"\"}]}', 4, 1),
(6, 'large_banner', 'Nagy banner	', '{\"pre_title\":\"sok cucc van\",\"title\":\"VEDD MEG MERT 40% KEDVEZM\\u00c9NYED VAN\",\"subtitle\":\"\\u00e9rted ugye\",\"text_align\":\"center\",\"button_text\":\"Megn\\u00e9zem\",\"button_link\":\"#\",\"image_path\":\"uploads\\/big-banner.jpg\"}', 6, 1),
(7, 'brands_slider', 'Kiemelt márkáink', '{\"manufacturer_ids\":[\"2\",\"1\",\"3\"],\"limit\":\"12\"}', 7, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`, `slug`, `logo_path`, `image_path`) VALUES
(1, 'skoda', 'skoda', '', 'public/uploads/manufacturers/1758788830_partner1-1.png'),
(2, 'lada', 'lada', '', 'public/uploads/manufacturers/1758788836_partner2-1.png'),
(3, 'valami', 'valami', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `menu_items`
--

INSERT INTO `menu_items` (`id`, `label`, `url`, `parent_id`, `sort_order`, `is_visible`) VALUES
(1, 'Főoldal', 'index.php', 0, 10, 1),
(2, 'Termékek', 'categories.php', 0, 20, 1),
(3, 'Kapcsolat', 'contact.php', 0, 30, 1),
(5, 'hgfg', '/aszf', 0, 1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `customer_phone` varchar(50) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_hungarian_ci NOT NULL,
  `billing_address` text COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'Feldolgozás alatt',
  `payment_method` varchar(100) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'ÁSZF', 'aszf', '<div>\r\n<h3><strong>&Aacute;LTAL&Aacute;NOS SZERZŐD&Eacute;SI FELT&Eacute;TELEK</strong></h3>\r\n<p>T&aacute;j&eacute;koztatjuk, hogy &Ouml;n mint v&aacute;s&aacute;rl&oacute; (fogyaszt&oacute;) az&nbsp;XXXXXX.hu c&iacute;men el&eacute;rhető&nbsp;honlap haszn&aacute;lat&aacute;val kinyilv&aacute;n&iacute;tja, hogy ismeri &eacute;s elfogadja, az al&aacute;bbi, a Ptk. (2013. &eacute;vi V. t&ouml;rv&eacute;ny) 6:77-6:81.&sect; alapj&aacute;n meg&iacute;rt &aacute;ltal&aacute;nos szerződ&eacute;si felt&eacute;teleket.&nbsp;K&eacute;rj&uuml;k, amennyiben v&aacute;s&aacute;rl&oacute;ja, illetve akt&iacute;v haszn&aacute;l&oacute;ja k&iacute;v&aacute;n lenni a Web&aacute;ruh&aacute;zunk &aacute;ltal k&iacute;n&aacute;lt lehetős&eacute;geknek, figyelmesen olvassa el az &Aacute;ltal&aacute;nos Szerződ&eacute;si Felt&eacute;teleinket &eacute;s kiz&aacute;r&oacute;lag abban az esetben vegye ig&eacute;nybe szolg&aacute;ltat&aacute;sainkat, amennyiben minden pontj&aacute;val egyet&eacute;rt, &eacute;s azokat k&ouml;telező &eacute;rv&eacute;nyűnek tekinti mag&aacute;ra n&eacute;zve.</p>\r\n<p>Jelen dokumentum, kiz&aacute;r&oacute;lag elektronikus form&aacute;ban ker&uuml;l megk&ouml;t&eacute;sre. Az al&aacute;bbi felt&eacute;telekkel szab&aacute;lyozott szerződ&eacute;s a Ptk. szerint t&aacute;vollevők k&ouml;z&ouml;tt l&eacute;trej&ouml;tt szerződ&eacute;snek minős&uuml;l.</p>\r\n<p><strong>1. &Uuml;zemeltetői adatok:</strong></p>\r\n<p><em>T&ouml;ltsd ki az itt tal&aacute;lhat&oacute; adatokat, sz&uuml;ks&eacute;g szerint&nbsp;eg&eacute;sz&iacute;tsd ki azokat.</em></p>\r\n<ul>\r\n<li>C&eacute;gn&eacute;v:</li>\r\n<li>Sz&eacute;khely:</li>\r\n<li>Ad&oacute;sz&aacute;m:&nbsp;<em>XXXXXXXX-X-XX</em></li>\r\n<li>C&eacute;gjegyz&eacute;k sz&aacute;m: Cg.&nbsp;<em>XX-XX-XXXXXX</em>, Kibocs&aacute;t&oacute; c&eacute;gb&iacute;r&oacute;s&aacute;g:&nbsp;</li>\r\n<li>Szerződ&eacute;s nyelve: magyar</li>\r\n<li>Elektronikus el&eacute;rhetős&eacute;g:&nbsp;<em>@</em></li>\r\n<li>Telefonos el&eacute;rhetős&eacute;g:&nbsp;<em>+36&nbsp;</em></li>\r\n<li>Sz&aacute;mlasz&aacute;m:&nbsp;</li>\r\n<li>Nyilv&aacute;ntart&aacute;sba vevő hat&oacute;s&aacute;g:</li>\r\n</ul>\r\n<p>A t&aacute;rhelyszolg&aacute;ltat&oacute; el&eacute;rhetős&eacute;gei:&nbsp;<em>XXX</em></p>\r\n<p>A szolg&aacute;ltat&oacute; a jelen &aacute;ltal&aacute;nos szerződ&eacute;si felt&eacute;telekben a tov&aacute;bbiakban: &uuml;zemeltető.</p>\r\n<p><strong>2.&nbsp;Megv&aacute;s&aacute;rolhat&oacute; term&eacute;kek, szolg&aacute;ltat&aacute;sok k&ouml;re</strong></p>\r\n<p><em>Itt kell felsorolni a term&eacute;keket, amiket a Web&aacute;ruh&aacute;zban forgalmazni szeretn&eacute;l.</em></p>\r\n<p>Figyelmeztet&eacute;s: A term&eacute;kek adatlapj&aacute;n megjelen&iacute;tett k&eacute;pek elt&eacute;rhetnek a val&oacute;s&aacute;gost&oacute;l, bizonyos esetekben csak illusztr&aacute;ci&oacute;k&eacute;nt szerepelnek.</p>\r\n<p><strong>3. Rendel&eacute;si inform&aacute;ci&oacute;k</strong></p>\r\n<p><em>Figyelmesen olvasd el a rendel&eacute;si inform&aacute;ci&oacute;kat, &eacute;s&nbsp;&iacute;rd &aacute;t&nbsp;a saj&aacute;t elk&eacute;pzel&eacute;seid szerint, az al&aacute;bbiakhoz hasonl&oacute;an:</em></p>\r\n<p>A megjelen&iacute;tett term&eacute;kek kiz&aacute;r&oacute;lag&nbsp;a Web&aacute;ruh&aacute;zon kereszt&uuml;l, online&nbsp;rendelhetőek meg, fut&aacute;r &aacute;ltal t&ouml;rt&eacute;nő h&aacute;zhoz sz&aacute;ll&iacute;t&aacute;ssal vagy szem&eacute;lyesen a megrendelő, vagy meghatalmazottja &aacute;ltali &aacute;tv&eacute;tellel.</p>\r\n<p>A term&eacute;kekre vonatkoz&oacute;an megjelen&iacute;tett &aacute;rak tartalmazz&aacute;k a t&ouml;rv&eacute;nyben elő&iacute;rt 27%-os &Aacute;FA-t, azonban nem tartalmazz&aacute;k a h&aacute;zhoz sz&aacute;ll&iacute;t&aacute;s d&iacute;j&aacute;t.</p>\r\n<p>Amennyiben az &uuml;zemeltető hib&aacute;s &aacute;rat t&uuml;ntet fel a term&eacute;k mellett, a tőle elv&aacute;rhat&oacute; gondoss&aacute;g ellen&eacute;re, &eacute;s a term&eacute;k &aacute;ra annak &aacute;ltal&aacute;nosan elfogadott &aacute;r&aacute;t&oacute;l elt&eacute;r,&uacute;gy az &uuml;zemeltető nem k&ouml;teles a term&eacute;ket a hib&aacute;s &aacute;ron szolg&aacute;ltatni, de k&ouml;teles a megrendel&eacute;s visszaigazol&aacute;s&aacute;ban felaj&aacute;nlani a v&aacute;s&aacute;rl&oacute; r&eacute;sz&eacute;re a val&oacute;s &aacute;ron t&ouml;rt&eacute;nő v&aacute;s&aacute;rl&aacute;s lehetős&eacute;g&eacute;t. Amennyiben a v&aacute;s&aacute;rl&oacute; ezzel a lehetős&eacute;ggel nem k&iacute;v&aacute;n &eacute;lni, &uacute;gy megilleti a szerződ&eacute;stől val&oacute; egyoldal&uacute; el&aacute;ll&aacute;s joga.</p>\r\n<p>K&uuml;l&ouml;n csomagol&aacute;si k&ouml;lts&eacute;g nem ker&uuml;l felsz&aacute;m&iacute;t&aacute;sra. A r&eacute;szletes sz&aacute;ll&iacute;t&aacute;si d&iacute;jszab&aacute;s a jelen szerződ&eacute;si felt&eacute;telek r&eacute;sze, a Sz&aacute;ll&iacute;t&aacute;si felt&eacute;telek men&uuml;pont alatt.&nbsp;<em>K&eacute;sz&iacute;ts k&uuml;l&ouml;n men&uuml;pontot a sz&aacute;ll&iacute;t&aacute;si felt&eacute;teleknek a saj&aacute;t sz&aacute;ll&iacute;t&aacute;si ir&aacute;nyelveid szerint!</em></p>\r\n<p>Web&aacute;ruh&aacute;zunkban term&eacute;kkateg&oacute;ri&aacute;k szerint b&ouml;ng&eacute;szhet a Megv&aacute;s&aacute;rolhat&oacute; term&eacute;kek, szolg&aacute;ltat&aacute;sok k&ouml;z&ouml;tt.&nbsp;A felsorolt term&eacute;kek mellett megtekintheti egy-egy term&eacute;kek r&ouml;vid le&iacute;r&aacute;s&aacute;t, &aacute;r&aacute;t, egy&eacute;b tulajdons&aacute;gait, a teljess&eacute;g ig&eacute;nye n&eacute;lk&uuml;l. Ha bővebb inform&aacute;ci&oacute;t szeretne kapni a term&eacute;kről, akkor kattintson a term&eacute;k k&eacute;p&eacute;re vagy nev&eacute;re. Ekkor a term&eacute;k oldal&aacute;ra jut el, ahol a term&eacute;kről r&eacute;szletesebb t&aacute;j&eacute;koztat&aacute;st kaphat. Amennyiben enn&eacute;l r&eacute;szletesebb t&aacute;j&eacute;koztat&aacute;sra van sz&uuml;ks&eacute;ge, &uacute;gy az &uuml;zemeltetői adatok k&ouml;z&ouml;tt r&ouml;gz&iacute;tett telefonsz&aacute;mon sz&iacute;veskedjen felvenni a kapcsolatot az &uuml;zemeltetővel.</p>\r\n<p><strong>A rendel&eacute;s menete</strong></p>\r\n<p><em>Figyelmesen olvasd el az itt le&iacute;rtakat, mert nem biztos, hogy n&aacute;lad is ugyan&iacute;gy műk&ouml;dik az &aacute;ruh&aacute;z. A le&iacute;rtakat alak&iacute;tsd &aacute;t a saj&aacute;t Web&aacute;ruh&aacute;zad műk&ouml;d&eacute;se szerint!</em></p>\r\n<p>A. A kos&aacute;r jelre kattintva a term&eacute;ket a Kos&aacute;rba helyezheti.</p>\r\n<p>A term&eacute;keket a Kos&aacute;rba helyezheti bejelentkez&eacute;s n&eacute;lk&uuml;l is azonban megrendel&eacute;s előtt &Ouml;nnek be kell l&eacute;pnie a rendszerbe. Ezt csak akkor tudja megtenni, ha regisztr&aacute;lja mag&aacute;t. A regisztr&aacute;ci&oacute;t a k&ouml;vetkező men&uuml;pont alatt tal&aacute;lja.&nbsp;Ha &Ouml;n regisztr&aacute;lt v&aacute;s&aacute;rl&oacute;, de elfelejtette jelszav&aacute;t, haszn&aacute;lja a jelsz&oacute; Bejelentkez&eacute;s eml&eacute;keztetőt. Ha itt megadja a regisztr&aacute;lt e-mail c&iacute;m&eacute;t, akkor a jelszav&aacute;t e-mailben elk&uuml;ldj&uuml;k &Ouml;nnek.&nbsp;Bel&eacute;p&eacute;st a Bejelentkez&eacute;s men&uuml;pont seg&iacute;ts&eacute;g&eacute;vel v&eacute;gezheti el. Itt adja meg regisztr&aacute;lt e-mail c&iacute;m&eacute;t &eacute;s jelszav&aacute;t, majd nyomja meg a bel&eacute;p&eacute;s gombot. Ha sikeres a bel&eacute;p&eacute;s, akkor ebben az ablakban megjelenik az &Ouml;n regisztr&aacute;lt e-mail c&iacute;me &eacute;s a kil&eacute;p&eacute;s gomb, amely seg&iacute;ts&eacute;g&eacute;vel elhagyhatja az &aacute;ruh&aacute;zat.</p>\r\n<p>B.&nbsp;A kos&aacute;r tartalm&aacute;t a Kos&aacute;r men&uuml;pont seg&iacute;ts&eacute;g&eacute;vel ellenőrizheti, szerkesztheti. Lehetős&eacute;g van arra, hogy megtekintse &eacute;s m&oacute;dos&iacute;tsa ,hogy a kos&aacute;rba tett term&eacute;kből milyen mennyis&eacute;get k&iacute;v&aacute;n rendelni, valamint ki tudja v&aacute;lasztani az &Ouml;nnek legmegfelelőbb fizet&eacute;si &eacute;s sz&aacute;ll&iacute;t&aacute;si m&oacute;dot, illetve t&ouml;r&ouml;lheti az adott t&eacute;telt. Lehetős&eacute;g van a kos&aacute;r teljes ki&uuml;r&iacute;t&eacute;s&eacute;re is. Amennyiben szeretne tov&aacute;bbi term&eacute;ket kos&aacute;rba helyezni, v&aacute;lassza a &bdquo;v&aacute;s&aacute;rl&aacute;s folytat&aacute;sa&rdquo; gombot Ha minden rendben van &eacute;s a megrendel&eacute;s mellett d&ouml;nt&ouml;tt akkor a P&eacute;nzt&aacute;r gombot megnyomva v&eacute;gleges&iacute;theti a megrendel&eacute;s&eacute;t.</p>\r\n<p>C.&nbsp;Miut&aacute;n v&eacute;gleges&iacute;tette rendel&eacute;s&eacute;t a megadott e-mail c&iacute;m&eacute;re k&uuml;ld&uuml;nk &Ouml;nnek egy automatikus visszaigazol&aacute;st, amely tartalmazza megrendel&eacute;se adatait. Amennyiben nem kap ilyen levelet a rendszer nem fogadta el megrendel&eacute;s&eacute;t. Ilyen esetben k&eacute;rj&uuml;k, vegye fel vel&uuml;nk a kapcsolatot, a m&aacute;r jelzett m&oacute;don, az &uuml;zemeltetői adatok seg&iacute;ts&eacute;g&eacute;vel.</p>\r\n<p>Miut&aacute;n elv&eacute;gezt&uuml;k megrendel&eacute;s&eacute;nek feldolgoz&aacute;s&aacute;t, a megadott e-mail c&iacute;m&eacute;re k&uuml;ld&uuml;nk &Ouml;nnek egy Megrendel&eacute;s lez&aacute;rva visszaigazol&aacute;st. A term&eacute;k kisz&aacute;ll&iacute;t&aacute;s&aacute;ra csak ezt k&ouml;vetően ker&uuml;l sor.</p>\r\n<p>A megrendel&eacute;s&eacute;nek folyamat&aacute;t a megrendel&eacute;s lez&aacute;r&aacute;s&aacute;ig figyelemmel k&iacute;s&eacute;rheti a Megrendel&eacute;s k&ouml;vet&eacute;s men&uuml;pont seg&iacute;ts&eacute;g&eacute;vel. Itt megtal&aacute;lhatja az &ouml;sszes eddigi megrendel&eacute;s&eacute;t is, amit Web&aacute;ruh&aacute;zunkba k&uuml;ld&ouml;tt. Minden megrendel&eacute;s egy egyedi megrendel&eacute;s sz&aacute;mmal azonos&iacute;that&oacute;.</p>\r\n<p><strong>4. Regisztr&aacute;ci&oacute;</strong></p>\r\n<p><em>Figyelmesen olvasd el az itt le&iacute;rtakat, mert nem biztos, hogy n&aacute;lad is ugyan&iacute;gy műk&ouml;dik az &aacute;ruh&aacute;z. A le&iacute;rtakat alak&iacute;tsd &aacute;t a saj&aacute;t Web&aacute;ruh&aacute;zad műk&ouml;d&eacute;se szerint!</em></p>\r\n<p>Amennyiben v&aacute;s&aacute;rolni szeretne, &uacute;gy az első v&aacute;s&aacute;rl&aacute;s alkalm&aacute;val meg kell adnia a v&aacute;s&aacute;rl&aacute;shoz sz&uuml;ks&eacute;ges adatokat is, &iacute;gy a nev&eacute;t, sz&aacute;ml&aacute;z&aacute;si &eacute;s sz&aacute;ll&iacute;t&aacute;si adatait, e-mail c&iacute;m&eacute;t, valamint a k&eacute;sőbbi bel&eacute;p&eacute;shez sz&uuml;ks&eacute;ges jelszav&aacute;t. A regisztr&aacute;ci&oacute; v&eacute;gleges&iacute;t&eacute;se előtt sz&uuml;ks&eacute;ges a regisztr&aacute;ci&oacute;s felt&eacute;telek elfogad&aacute;sa is. A regisztr&aacute;ci&oacute;t e-mailben visszaigazolja a rendszer. A vevő k&ouml;teles az &aacute;ltala megadott jelsz&oacute;t bizalmasan kezelni. Amennyiben az azonos&iacute;t&aacute;s sor&aacute;n a vevő egyedi azonos&iacute;t&oacute;ja &eacute;s jelszava helyes megad&aacute;s&aacute;t k&ouml;vetően a vevő adatai arra jogosulatlan harmadik szem&eacute;ly birtok&aacute;ba ker&uuml;ltek, az ebből eredő k&aacute;rok&eacute;rt, illetve h&aacute;tr&aacute;nyok&eacute;rt az Adatkezelő felelőss&eacute;get nem v&aacute;llal. A felhaszn&aacute;l&oacute;k e-mail c&iacute;m&uuml;k megad&aacute;s&aacute;val hozz&aacute;j&aacute;rulnak ahhoz, hogy az &uuml;zemeltető/ szolg&aacute;ltat&oacute; technikai jellegű &uuml;zenetet k&uuml;ldj&ouml;n sz&aacute;mukra. A regisztr&aacute;lt adatokat az &uuml;zemeltető k&eacute;relemre t&ouml;rli a rendszerből. A t&ouml;rl&eacute;si k&eacute;relem biztons&aacute;gi okokb&oacute;l csak akkor lesz &eacute;rv&eacute;nyes, ha a t&ouml;rl&eacute;si k&eacute;relmet a felhaszn&aacute;l&oacute; e-mailben megerős&iacute;ti, &iacute;gy elker&uuml;lhető, hogy valaki sz&aacute;nd&eacute;kosan vagy t&eacute;ved&eacute;sből m&aacute;st t&ouml;r&ouml;lj&ouml;n a regisztr&aacute;ci&oacute;s adatb&aacute;zisb&oacute;l. A regisztr&aacute;ci&oacute;t az e-mail c&iacute;m azonos&iacute;tja, teh&aacute;t egy e-mail c&iacute;met csak egyszer lehet regisztr&aacute;lni.&nbsp;</p>\r\n<p>A regisztr&aacute;ci&oacute; k&ouml;telezetts&eacute;gekkel nem j&aacute;r.</p>\r\n<p><strong>5. A megrendel&eacute;sek feldolgoz&aacute;sa</strong></p>\r\n<p><em>T&ouml;ltsd ki az itt tal&aacute;lhat&oacute; adatokat, sz&uuml;ks&eacute;g szerint&nbsp;eg&eacute;sz&iacute;tsd ki azokat.</em></p>\r\n<p>A megrendel&eacute;sek feldolgoz&aacute;sa munkanapokon / XX t&ouml;rt&eacute;nik XX-XX&nbsp;&oacute;r&aacute;ig.&nbsp;A megrendel&eacute;s feldolgoz&aacute;sak&eacute;nt megjel&ouml;lt időpontokon k&iacute;v&uuml;l is van lehetős&eacute;g a megrendel&eacute;sre, de ha az a munkaidő lej&aacute;rta ut&aacute;n t&ouml;rt&eacute;nik, csak az azt k&ouml;vető munkanapon ker&uuml;l feldolgoz&aacute;sra a megrendel&eacute;s.&nbsp;Az elfogadott megrendel&eacute;s teljes&iacute;t&eacute;si hat&aacute;rideje, a visszaigazol&aacute;st&oacute;l sz&aacute;m&iacute;tva a rakt&aacute;ron l&eacute;vő term&eacute;kek eset&eacute;ben XX - XX&nbsp;munkanap. Abban az esetben, ha a term&eacute;k nincs rakt&aacute;ron, &uacute;gy a beszerz&eacute;si hely&eacute;től f&uuml;ggően XX-XX h&eacute;t.</p>\r\n<p>C&eacute;g&uuml;nk nem v&aacute;llal felelőss&eacute;get a megrendelt term&eacute;k esetleges technikai ismertetőinek a besz&aacute;ll&iacute;t&oacute;, vagy rajta k&iacute;v&uuml;l &aacute;ll&oacute; okok miatt t&ouml;rt&eacute;nő előzetes bejelent&eacute;s n&eacute;lk&uuml;li v&aacute;ltoz&aacute;sa miatt.</p>\r\n<p><strong>6. A megrendelt term&eacute;k ellen&eacute;rt&eacute;k&eacute;nek &eacute;s a h&aacute;zhoz sz&aacute;ll&iacute;t&aacute;s d&iacute;j&aacute;nak fizet&eacute;s&eacute;nek m&oacute;dja</strong></p>\r\n<p><em>Figyelmesen olvasd el az itt le&iacute;rtakat, mert nem biztos, hogy n&aacute;lad is ugyan&iacute;gy műk&ouml;dik az &aacute;ruh&aacute;z. A le&iacute;rtakat alak&iacute;tsd &aacute;t a saj&aacute;t Web&aacute;ruh&aacute;zad műk&ouml;d&eacute;se szerint!</em></p>\r\n<p>A megrendelt term&eacute;k fizet&eacute;s&eacute;nek m&oacute;dja</p>\r\n<ul>\r\n<li>Banki előre utal&aacute;ssal t&ouml;rt&eacute;nő teljes&iacute;t&eacute;s: ha m&aacute;r visszaigazoltuk az &Ouml;n megrendel&eacute;s&eacute;t, akkor a visszaigazol&oacute; e-mailben megtal&aacute;lja a banksz&aacute;mlasz&aacute;munkat &eacute;s a megrendel&eacute;ssz&aacute;mot, amelyre hivatkozni kell az &aacute;tutal&aacute;s megjegyz&eacute;s / k&ouml;zlem&eacute;ny rovat&aacute;ban. Amennyiben az &aacute;tutalt &ouml;sszeget j&oacute;v&aacute;&iacute;rj&aacute;k a banksz&aacute;ml&aacute;nkon, csak ezt k&ouml;vetően adjuk fel a fut&aacute;rszolg&aacute;lattal a term&eacute;ket.(banksz&aacute;mlasz&aacute;munkat az &uuml;zemeltetői adatok k&ouml;z&ouml;tt tal&aacute;lja meg)</li>\r\n<li>Szem&eacute;lyesen t&ouml;rt&eacute;nő teljes&iacute;t&eacute;s:&nbsp;Ez esetben &Ouml;n az &uuml;zemeltető sz&eacute;khely&eacute;n/telephely&eacute;n forintban fizeti meg a term&eacute;k v&eacute;tel&aacute;r&aacute;t, vagy k&eacute;szp&eacute;nzben, vagy bankk&aacute;rty&aacute;val.</li>\r\n<li>Bankk&aacute;rty&aacute;val t&ouml;rt&eacute;nő fizet&eacute;s a k&ouml;vetkező, &eacute;rv&eacute;nyes &eacute;s hat&aacute;lyos bankk&aacute;rty&aacute;k tulajdonosai sz&aacute;m&aacute;ra lehets&eacute;ges:&nbsp;<em>Itt kell&nbsp;felsorolni az elfogadhat&oacute; k&aacute;rty&aacute;kat, pl. MasterCard, Visa Stb.</em></li>\r\n<li>Ut&aacute;nv&eacute;ttel t&ouml;rt&eacute;nő teljes&iacute;t&eacute;s: A term&eacute;ket az &aacute;ltalunk megb&iacute;zott ( ide a neve)fut&aacute;rszolg&aacute;lat sz&aacute;ll&iacute;tja ki az &Ouml;n &aacute;ltal megadott c&iacute;mre, ahol a term&eacute;k, vagy term&eacute;kek sz&aacute;mla szerinti &aacute;r&aacute;t a fut&aacute;rnak kell k&eacute;szp&eacute;nzben kifizetni. Ut&aacute;nv&eacute;tes megrendel&eacute;s eset&eacute;n a sz&aacute;ll&iacute;t&aacute;si k&ouml;lts&eacute;ghez az ut&aacute;nv&eacute;teli d&iacute;j m&eacute;g hozz&aacute;ad&oacute;dik.</li>\r\n<li>Ut&aacute;nv&eacute;ttel fizet&eacute;s eset&eacute;n a megrendelt term&eacute;ket a csomag &aacute;tv&eacute;telekor a k&eacute;zbes&iacute;tőnek k&eacute;szp&eacute;nzben kell kifizetni.&nbsp;</li>\r\n</ul>\r\n<p>A fizetendő v&eacute;g&ouml;sszeg a megrendel&eacute;s &ouml;sszes&iacute;tője &eacute;s visszaigazol&oacute; lev&eacute;l alapj&aacute;n minden k&ouml;lts&eacute;get tartalmaz. A sz&aacute;ml&aacute;t &eacute;s a garancialevelet a csomag tartalmazza. K&eacute;rj&uuml;k a csomagot k&eacute;zbes&iacute;t&eacute;skor a k&eacute;zbes&iacute;tő előtt sz&iacute;veskedj&eacute;k megvizsg&aacute;lni, &eacute;s esetlegesen a term&eacute;keken &eacute;szlelt s&eacute;r&uuml;l&eacute;s, vagy hi&aacute;ny eset&eacute;n k&eacute;rje jegyzők&ouml;nyv felv&eacute;tel&eacute;t &eacute;s ne vegye &aacute;t a csomagot. Ut&oacute;lagos, jegyzők&ouml;nyv n&eacute;lk&uuml;li reklam&aacute;ci&oacute;t nem &aacute;ll m&oacute;dunkban elfogadni.</p>\r\n<p><strong>H&aacute;zhoz sz&aacute;ll&iacute;t&aacute;s d&iacute;jszab&aacute;sa</strong></p>\r\n<p><em>Eg&eacute;sz&iacute;tsd ki az itt le&iacute;rtakat a saj&aacute;t d&iacute;jszab&aacute;sod szerint!</em></p>\r\n<ul>\r\n<li>Rendel&eacute;si &eacute;rt&eacute;k 0-XXX&nbsp;Ft k&ouml;z&ouml;tt a h&aacute;zhoz sz&aacute;ll&iacute;t&aacute;s d&iacute;ja: XXX Ft.</li>\r\n<li>Rendel&eacute;si &eacute;rt&eacute;k&nbsp;XXX-YYY&nbsp;Ft k&ouml;z&ouml;tt a h&aacute;zhoz sz&aacute;ll&iacute;t&aacute;s d&iacute;ja: ZZZ Ft.</li>\r\n<li>Rendel&eacute;si &eacute;rt&eacute;k ZZZ&nbsp;Ft felett&nbsp;ingyenes.</li>\r\n<li>Ut&aacute;nv&eacute;teles megrendel&eacute;s eset&eacute;n a sz&aacute;ll&iacute;t&aacute;si k&ouml;lts&eacute;ghez az ut&aacute;nv&eacute;teli d&iacute;j a rendel&eacute;s &eacute;rt&eacute;k&eacute;hez hozz&aacute;ad&oacute;dik.</li>\r\n</ul>\r\n<p><strong>7. Sz&aacute;ll&iacute;t&aacute;si hat&aacute;ridő</strong></p>\r\n<p><em>M&oacute;dos&iacute;tsd&nbsp;az itt le&iacute;rtakat a saj&aacute;t sz&aacute;ll&iacute;t&aacute;si hat&aacute;ridőid szerint!</em></p>\r\n<p>Rakt&aacute;ron l&eacute;vő term&eacute;kek eset&eacute;ben a megrendel&eacute;s visszaigazol&aacute;s&aacute;t&oacute;l sz&aacute;mitott XXX - XXX munkanap. Abban az esetben, ha a term&eacute;k nincs rakt&aacute;ron XXX-XXX&nbsp;h&eacute;t</p>\r\n<p><strong>8. H&aacute;zhoz sz&aacute;ll&iacute;t&aacute;si inform&aacute;ci&oacute;k</strong></p>\r\n<p><em>M&oacute;dos&iacute;tsd&nbsp;az itt le&iacute;rtakat a saj&aacute;t&nbsp;h&aacute;zhoz sz&aacute;ll&iacute;t&aacute;si inform&aacute;ci&oacute;id&nbsp;szerint!</em></p>\r\n<p>A web&aacute;ruh&aacute;zunk &aacute;ltal kapott megrendel&eacute;seket kiz&aacute;r&oacute;lag a(z) XXX fut&aacute;rszolg&aacute;lat fut&aacute;rai k&eacute;zbes&iacute;tik. A csomagok k&eacute;zbes&iacute;t&eacute;se munkanapokon t&ouml;rt&eacute;nik XXX-XXX&nbsp;&oacute;ra k&ouml;z&ouml;tt. Sz&aacute;ll&iacute;t&aacute;si c&iacute;mk&eacute;nt c&eacute;lszerű olyan c&iacute;met megadni, ahol a most megjel&ouml;lt napszakban a fut&aacute;rt folyamatosan fogadni tudj&aacute;k, &eacute;s biztos&iacute;tani tudj&aacute;k a k&uuml;ldem&eacute;ny ellen&eacute;rt&eacute;k&eacute;nek &eacute;s a sz&aacute;ll&iacute;t&aacute;si d&iacute;jnak, valamint az ut&aacute;nv&eacute;tel d&iacute;j&aacute;nak a fut&aacute;r r&eacute;sz&eacute;re val&oacute; teljes&iacute;t&eacute;s&eacute;t.</p>\r\n<p>Kiz&aacute;r&oacute;lag abban az esetben rendelje meg a k&iacute;v&aacute;nt term&eacute;keket, amennyiben a csomag &aacute;tv&eacute;telekor ki tudja fizetni annak d&iacute;j&aacute;t a fut&aacute;rnak.&nbsp;Az &aacute;t nem vett, visszak&uuml;ld&ouml;tt csomagok eset&eacute;ben a sz&aacute;ll&iacute;t&aacute;s &eacute;s visszasz&aacute;ll&iacute;t&aacute;s d&iacute;j&aacute;t a megrendelőre terhelj&uuml;k, &uacute;jrak&uuml;ld&eacute;s&eacute;t kiz&aacute;r&oacute;lag a csomag ellen&eacute;rt&eacute;k&eacute;nek előre t&ouml;rt&eacute;nő kiegyenl&iacute;t&eacute;se eset&eacute;n &aacute;ll m&oacute;dunkban ism&eacute;telten elind&iacute;tani.&nbsp;</p>\r\n<p>&Aacute;ruh&aacute;zunk műk&ouml;d&eacute;s&eacute;vel, megrendel&eacute;si, &eacute;s sz&aacute;ll&iacute;t&aacute;si folyamat&aacute;val kapcsolatosan felmer&uuml;lő esetleges tov&aacute;bbi k&eacute;rd&eacute;sek eset&eacute;n az &uuml;zemeltető adatai k&ouml;z&ouml;tt megadott el&eacute;rhetős&eacute;geinken rendelkez&eacute;s&eacute;re &aacute;llunk.</p>\r\n<p><strong>9. Postai sz&aacute;ll&iacute;t&aacute;ssal kapcsolatos inform&aacute;ci&oacute;k</strong></p>\r\n<p><em>M&oacute;dos&iacute;tsd&nbsp;az itt le&iacute;rtakat a postai sz&aacute;ll&iacute;t&aacute;ssal kapcsolatos inform&aacute;ci&oacute;id&nbsp;szerint!</em></p>\r\n<p>A postai k&uuml;ldem&eacute;ny elvesz&eacute;s&eacute;t, r&eacute;szleges elvesz&eacute;s&eacute;t, megs&eacute;r&uuml;l&eacute;s&eacute;t, vagy megsemmis&uuml;l&eacute;s&eacute;t a k&eacute;zbes&iacute;t&eacute;skor, a k&eacute;zbes&iacute;t&eacute;si okiraton azonnal jeleznie kell. Ennek elmulaszt&aacute;sa jogveszt&eacute;ssel j&aacute;r. K&eacute;zbes&iacute;t&eacute;si okirat hi&aacute;ny&aacute;ban, a k&uuml;ldem&eacute;nyre vonatkoz&oacute; egy&eacute;b okirattal a posta fel&eacute; jogvesztő hat&aacute;ridőn bel&uuml;l &ndash; vagyis a k&eacute;zbes&iacute;t&eacute;si napt&oacute;l sz&aacute;m&iacute;tott 3 napon bel&uuml;l &ndash; a k&aacute;rt azonnal jeleznie kell.</p>\r\n<p><strong>10. El&aacute;ll&aacute;s joga</strong></p>\r\n<p><em>Sok itt le&iacute;rt adat - p&eacute;ld&aacute;ul a k&ouml;telező 14 napod el&aacute;ll&aacute;si hat&aacute;ridő - a t&ouml;rv&eacute;nyben megfogalmazott elő&iacute;r&aacute;s. Figyelmesen olvasd el a le&iacute;rtakat, &eacute;s alak&iacute;tsd &aacute;t, eg&eacute;sz&iacute;tsd ki őket a saj&aacute;t Web&aacute;ruh&aacute;zad műk&ouml;d&eacute;se szerint!</em></p>\r\n<p>A t&aacute;vollevők k&ouml;z&ouml;tt k&ouml;t&ouml;tt szerződ&eacute;sekről sz&oacute;l&oacute;, 45/2014. korm&aacute;nyrendelet szab&aacute;lyoz&aacute;sa &eacute;rtelm&eacute;ben a jelen pont rendelkez&eacute;sei kiz&aacute;r&oacute;lag a fogyaszt&oacute;nak minős&uuml;lő v&aacute;s&aacute;rl&oacute; eset&eacute;ben alkalmazhat&oacute;ak.&nbsp;A fogyaszt&oacute; a megrendelt term&eacute;k k&eacute;zhez v&eacute;tel&eacute;től sz&aacute;m&iacute;tott 14 munkanapon bel&uuml;l indokl&aacute;s n&eacute;lk&uuml;l el&aacute;llhat a szerződ&eacute;stől, visszak&uuml;ldheti a megrendelt, bontatlan csomagol&aacute;s&uacute; term&eacute;ket.&nbsp;Amennyiben a fogyaszt&oacute; &eacute;l el&aacute;ll&aacute;si jog&aacute;val, &uacute;gy ezt az &uuml;zemeltetővel egy&eacute;rtelmű &iacute;r&aacute;sbeli nyilatkozatban k&ouml;teles k&ouml;z&ouml;lni (post&aacute;n aj&aacute;nlott t&eacute;rtivev&eacute;nyes k&uuml;ldem&eacute;nyben, vagy e-mailben). Az &uuml;zemeltető az el&aacute;ll&aacute;si nyilatkozat k&eacute;zhezv&eacute;tel&eacute;t k&ouml;vetően halad&eacute;ktalanul k&ouml;teles azt visszaigazolni a fogyaszt&oacute; fel&eacute;. A fogyaszt&oacute; el&aacute;ll&aacute;sa eset&eacute;n a megrendelt term&eacute;ket k&ouml;teles el&aacute;ll&aacute;si nyilatkozat&aacute;nak k&ouml;zl&eacute;s&eacute;től sz&aacute;m&iacute;tott 14 napon bel&uuml;l az &uuml;zemeltetőnek visszak&uuml;ldeni. A visszak&uuml;ld&eacute;s k&ouml;lts&eacute;ge a fogyaszt&oacute;t terheli.</p>\r\n<p>Amennyiben a fogyaszt&oacute; el&aacute;ll&aacute;si jog&aacute;t gyakorolja, &uacute;gy az erre vonatkoz&oacute; nyilatkozat k&eacute;zhezv&eacute;tel&eacute;t k&ouml;vető 14 napon bel&uuml;l k&ouml;teles az &uuml;zemeltető a fogyaszt&oacute;nak az &aacute;ltala teljes&iacute;tett fizet&eacute;seket visszat&eacute;r&iacute;teni, bele&eacute;rtve a sz&aacute;ll&iacute;t&aacute;s d&iacute;j&aacute;t is. Ez al&oacute;l kiv&eacute;tel, ha a fogyaszt&oacute; olyan fuvaroz&aacute;si m&oacute;dot v&aacute;lasztott, amely t&ouml;bbletk&ouml;lts&eacute;ggel j&aacute;r, &eacute;s amely a szok&aacute;sos fuvaroz&aacute;st&oacute;l elt&eacute;rő. A szolg&aacute;ltat&oacute;nak a visszafizet&eacute;si k&ouml;telezetts&eacute;g&eacute;t mindaddig nem kell teljes&iacute;tenie, am&iacute;g a szolg&aacute;ltatott term&eacute;ket vissza nem kapta, vagy am&iacute;g a fogyaszt&oacute; hitelt &eacute;rdemlő igazol&aacute;s&aacute;t a term&eacute;k visszak&uuml;ld&eacute;s&eacute;ről nem kapta meg. A k&eacute;t időpont k&ouml;z&ouml;tti elt&eacute;r&eacute;s eset&eacute;n az &uuml;zemeltető a kor&aacute;bbi időpontot kell, hogy figyelembe vegye.</p>\r\n<p>&Uuml;zemeltető k&ouml;vetelheti a fogyaszt&oacute;t&oacute;l a nem rendeltet&eacute;sszerű haszn&aacute;latb&oacute;l ad&oacute;d&oacute; anyagi k&aacute;r megt&eacute;r&iacute;t&eacute;s&eacute;t. Ez&eacute;rt kiemelten &uuml;gyeljen a term&eacute;k rendeltet&eacute;sszerű haszn&aacute;lat&aacute;ra, ugyanis a nem rendeltet&eacute;sszerű haszn&aacute;lat&aacute;b&oacute;l eredő k&aacute;roknak megt&eacute;r&iacute;t&eacute;se a fogyaszt&oacute;t terhelik.</p>\r\n<p>A csomag c&eacute;g&uuml;nkh&ouml;z t&ouml;rt&eacute;nő be&eacute;rkez&eacute;s&eacute;t k&ouml;vetően, vide&oacute; kamer&aacute;val r&ouml;gz&iacute;t&eacute;sre ker&uuml;l a csomag kibont&aacute;sa, illetve a visszak&uuml;ld&ouml;tt term&eacute;k megvizsg&aacute;l&aacute;sa. Erre az esetleges k&eacute;sőbbiekben t&ouml;rt&eacute;nő f&eacute;lre&eacute;rt&eacute;sek elker&uuml;l&eacute;se v&eacute;gett van sz&uuml;ks&eacute;g. (p&eacute;ld&aacute;ul, hogy a visszak&uuml;ld&ouml;tt term&eacute;k s&eacute;r&uuml;lt, vagy hi&aacute;nyos volt)</p>\r\n<p>Nem illeti meg a fogyaszt&oacute;t az el&aacute;ll&aacute;si jog:</p>\r\n<ul>\r\n<li>olyan term&eacute;k eset&eacute;n, melynek &aacute;ra a v&aacute;llalkoz&aacute;s &aacute;ltal nem ir&aacute;ny&iacute;that&oacute; p&eacute;nzpiaci mozg&aacute;sokt&oacute;l, ingadoz&aacute;sokt&oacute;l f&uuml;gg.</li>\r\n<li>olyan nem előre gy&aacute;rtott term&eacute;k eset&eacute;ben, amelyet kifejezetten a fogyaszt&oacute; k&eacute;r&eacute;s&eacute;re, az ő &aacute;ltal szabott ig&eacute;nyek alapj&aacute;n egyedi k&eacute;r&eacute;s&eacute;nek megfelelően ker&uuml;lt elő&aacute;ll&iacute;t&aacute;sra,</li>\r\n<li>olyan term&eacute;k eset&eacute;ben, amelyn&eacute;l a fogyaszt&oacute; kifejezett k&eacute;r&eacute;s&eacute;nek tesz eleget az &uuml;zemeltető s&uuml;rgős jav&iacute;t&aacute;si, vagy karbantart&aacute;si munk&aacute;kn&aacute;l</li>\r\n</ul>\r\n<p><strong>11. J&oacute;t&aacute;ll&aacute;s</strong></p>\r\n<p><em>M&oacute;dos&iacute;tsd&nbsp;az itt le&iacute;rtakat a saj&aacute;t j&oacute;t&aacute;ll&aacute;ssal kapcsolatos tudnival&oacute;id szerint!</em></p>\r\n<p>Az &uuml;zemeltető &aacute;ltal forgalmazott egyes term&eacute;kekre az egyes tart&oacute;s fogyaszt&aacute;si cikkekre vonatkoz&oacute; k&ouml;telező j&oacute;t&aacute;ll&aacute;s szab&aacute;lyait tartalmaz&oacute; 151/2003. Korm. rendelet szerint 1&nbsp;&eacute;ves j&oacute;t&aacute;ll&aacute;si idő &aacute;ll a fogyaszt&oacute; rendelkez&eacute;s&eacute;re a term&eacute;k &aacute;tad&aacute;s&aacute;nak napj&aacute;t&oacute;l. A v&aacute;s&aacute;rl&oacute;t a j&oacute;t&aacute;ll&aacute;s joga akkor nem illeti meg, ha a hiba a term&eacute;k fogyaszt&oacute; r&eacute;sz&eacute;re val&oacute; &aacute;tad&aacute;s&aacute;t k&ouml;vetően keletkezett.&nbsp;A megjel&ouml;lt rendelet al&aacute; nem tartoz&oacute; term&eacute;kek tekintet&eacute;ben a gy&aacute;rt&oacute; &aacute;ltal biztos&iacute;tott j&oacute;t&aacute;ll&aacute;si idő a term&eacute;k mellett felt&uuml;ntet&eacute;sre ker&uuml;l. Ezzel kapcsolatos probl&eacute;m&aacute;k felmer&uuml;l&eacute;se eset&eacute;n az &uuml;zemeltető pontos inform&aacute;ci&oacute;t tud adni.&nbsp;J&oacute;t&aacute;ll&aacute;s eset&eacute;ben a fogyaszt&oacute; a j&oacute;t&aacute;ll&aacute;si időn bel&uuml;l a meghib&aacute;sodott term&eacute;k d&iacute;jmentes jav&iacute;t&aacute;sa, vagy cser&eacute;je illeti meg. A garanci&aacute;lis jav&iacute;t&aacute;sok a gy&aacute;rt&aacute;si hib&aacute;b&oacute;l eredő meghib&aacute;sod&aacute;sokra terjednek ki. A garancia felt&eacute;telek a haszn&aacute;lati &uacute;tmutat&oacute;ban levő felt&eacute;telek betart&aacute;s&aacute;val egy&uuml;tt &eacute;rv&eacute;nyesek.</p>\r\n<p>Term&eacute;k meghib&aacute;sod&aacute;sa eset&eacute;n a k&eacute;sz&uuml;l&eacute;khez mell&eacute;kelt garancia lev&eacute;len megjel&ouml;lt c&iacute;men &eacute;s telefonsz&aacute;mon kaphat bővebb felvil&aacute;gos&iacute;t&aacute;st a teendőkről, tov&aacute;bb&aacute; el&eacute;rhetős&eacute;geink valamelyik&eacute;n.&nbsp;A term&eacute;kek garanci&aacute;lis szervizpontj&aacute;ra t&ouml;rt&eacute;nő eljuttat&aacute;s&aacute;nak k&ouml;lts&eacute;ge a v&aacute;s&aacute;rl&oacute;t terheli. A meghib&aacute;sodott k&eacute;sz&uuml;l&eacute;ket k&ouml;zvetlen&uuml;l web&aacute;ruh&aacute;zunk szervizpontj&aacute;ra is visszak&uuml;ldheti c&iacute;mre. Port&oacute;san k&uuml;ld&ouml;tt csomagokat nem vesz &aacute;t &aacute;tvevőpontunk, azt minden esetben visszak&uuml;ldi a felad&oacute;nak!&nbsp;A kijav&iacute;t&aacute;s sor&aacute;n a term&eacute;kbe csak &uacute;j alkatr&eacute;sz ker&uuml;lhet be&eacute;p&iacute;t&eacute;sre.&nbsp;Az &uuml;zemeltetőnek t&ouml;rekednie kell arra, hogy a kijav&iacute;t&aacute;st, vagy cser&eacute;t XXX&nbsp;napon bel&uuml;l elv&eacute;gezze. A j&oacute;t&aacute;ll&aacute;s k&ouml;r&eacute;ben v&eacute;gzett tev&eacute;kenys&eacute;g k&ouml;lts&eacute;gei az &uuml;zemeltetőt terhelik.</p>\r\n<p>Egyebekben a j&oacute;t&aacute;ll&aacute;sra a Ptk.6.171-173.&sect;-ban foglaltak az ir&aacute;nyad&oacute;ak.</p>\r\n<p><strong>12. Szavatoss&aacute;g</strong></p>\r\n<p>A szolg&aacute;ltatott term&eacute;k hib&aacute;ja eset&eacute;n az &uuml;zemeltetővel szemben kell&eacute;kszavatoss&aacute;gi ig&eacute;ny &eacute;rv&eacute;nyes&iacute;t&eacute;s&eacute;nek van helye a Ptk.&nbsp;6:159-167&nbsp;:&sect; i szerint.&nbsp;<em>T&ouml;ltsd ki&nbsp;ezt a r&eacute;szt&nbsp;a forgalmazott term&eacute;keidre vonatkoz&oacute; szavatoss&aacute;gi elő&iacute;r&aacute;said&nbsp;alapj&aacute;n!</em></p>\r\n<p><strong>13. Panaszok int&eacute;z&eacute;se</strong></p>\r\n<p><em>M&oacute;dos&iacute;tsd&nbsp;az itt le&iacute;rtakat a&nbsp;saj&aacute;t panaszkezel&eacute;si ir&aacute;nyelveid alapj&aacute;n! T&uuml;ntesd fel itt a b&eacute;k&eacute;ltető test&uuml;letekre vonatkoz&oacute; inform&aacute;ci&oacute;kat!</em></p>\r\n<p>Az &uuml;zemeltető a panaszr&oacute;l jegyzők&ouml;nyvet k&ouml;teles felvenni,az &uuml;zemeltető adati k&ouml;z&ouml;tt megjel&ouml;lt helyen, &eacute;s a panaszt a felv&eacute;tel napj&aacute;t&oacute;l sz&aacute;m&iacute;tott &ouml;t &eacute;vig, az arra adott v&aacute;lasszal egy&uuml;tt megőrizni.&nbsp;Az &uuml;zemeltető a hozz&aacute; &eacute;rkezett panaszt a be&eacute;rkez&eacute;s&eacute;től sz&aacute;m&iacute;tott 30 napon bel&uuml;l megvizsg&aacute;lja &eacute;s arra &eacute;rdemi v&aacute;laszt kell hogy adjon. Amennyiben panaszra az &uuml;zemeltető elutas&iacute;t&oacute; v&aacute;laszt ad, azt &iacute;r&aacute;sban meg kell indokolnia.&nbsp;Az &uuml;zemeltetővel k&ouml;t&ouml;tt szerződ&eacute;s&eacute;ből eredő jogvit&aacute;k elsősorban b&eacute;k&eacute;s &uacute;ton, meg&aacute;llapod&aacute;ssal a felek k&ouml;z&ouml;tt, vagy a fogyaszt&oacute; lak&oacute;helye szerint illet&eacute;kes fogyaszt&oacute;v&eacute;delmi hat&oacute;s&aacute;g előtt int&eacute;zhetők. Amennyiben ezek nem vezetnek eredm&eacute;nyre, marad a felek sz&aacute;m&aacute;ra a b&iacute;r&oacute;s&aacute;gi &uacute;t.</p>\r\n<p><strong>14. Adatkezel&eacute;s</strong></p>\r\n<p><em>M&oacute;dos&iacute;tsd&nbsp;az itt le&iacute;rtakat a&nbsp;saj&aacute;t adatkezel&eacute;si ir&aacute;nyelveid alapj&aacute;n!</em></p>\r\n<p>Az &uuml;zemeltető a web&aacute;ruh&aacute;z a haszn&aacute;lata sor&aacute;n a rendelkez&eacute;s&eacute;re bocs&aacute;tott szem&eacute;lyes adatokat bizalmasan kezeli, &eacute;s nem adja ki k&iacute;v&uuml;l&aacute;ll&oacute; harmadik szem&eacute;ly sz&aacute;m&aacute;ra, kiv&eacute;ve abban az esetben amennyiben a alv&aacute;llalkoz&oacute;ja sz&aacute;m&aacute;ra. (Pl: fut&aacute;rszolg&aacute;lat), a megrendel&eacute;s k&eacute;zbes&iacute;t&eacute;s&eacute;hez ez sz&uuml;ks&eacute;ges.&nbsp;</p>\r\n<p>A web&aacute;ruh&aacute;z b&ouml;ng&eacute;sz&eacute;se folyam&aacute;n technikai inform&aacute;ci&oacute;k ker&uuml;lnek r&ouml;gz&iacute;t&eacute;sre statisztikai c&eacute;lokb&oacute;l. (IP c&iacute;m, l&aacute;togat&aacute;s időtartama, stb). Ezen adatokat az &uuml;zemeltető kiz&aacute;r&oacute;lag jogilag hitelesen indokolt, &eacute;s al&aacute;t&aacute;masztott esetben adja &aacute;t a hat&oacute;s&aacute;gok r&eacute;sz&eacute;re. A szolg&aacute;ltat&aacute;s ig&eacute;nybev&eacute;tel&eacute;hez cookie-k enged&eacute;lyez&eacute;se sz&uuml;ks&eacute;ges. Amennyiben nem szeretn&eacute; enged&eacute;lyezi a cookie-k haszn&aacute;lat&aacute;t, letilthatja a b&ouml;ng&eacute;szője be&aacute;ll&iacute;t&aacute;saiban. Cookie-k tilt&aacute;sa eset&eacute;n a szolg&aacute;ltat&aacute;s bizonyos elemei csak r&eacute;szben, vagy egy&aacute;ltal&aacute;n nem haszn&aacute;lhat&oacute;ak. A cookie egy olyan f&aacute;jl, amelyet a szerver k&uuml;ld a felhaszn&aacute;l&oacute; b&ouml;ng&eacute;szőj&eacute;nek, &eacute;s amelyet a felhaszn&aacute;l&oacute; sz&aacute;m&iacute;t&oacute;g&eacute;pe t&aacute;rol. A cookie-ban szem&eacute;lyes adat nem ker&uuml;l t&aacute;rol&aacute;sra. A megrendel&eacute;s folyam&aacute;n r&ouml;gz&iacute;tett adatokat az &uuml;zemeltető a megrendel&eacute;s teljes&iacute;t&eacute;s&eacute;hez haszn&aacute;lja fel. Az egyes informatikai rendszerek &aacute;ltal, a web&aacute;ruh&aacute;z oldalain leadott megrendel&eacute;sből k&eacute;sz&uuml;lt sz&aacute;mla adatai a rendel&eacute;s lead&aacute;sa folyam&aacute;n megadott adatokkal r&ouml;gz&iacute;t&eacute;sre, &eacute;s t&aacute;rol&aacute;sra ker&uuml;lnek a hat&aacute;lyos sz&aacute;mviteli t&ouml;rv&eacute;nyben meghat&aacute;rozott időszakra. A web&aacute;ruh&aacute;z b&ouml;ng&eacute;sz&eacute;se illetve a regisztr&aacute;ci&oacute; folyam&aacute;n biztos&iacute;tott h&iacute;rlev&eacute;l feliratkoz&aacute;s sor&aacute;n megadott adatokat az &uuml;zemeltető bizalmasan kezeli, leiratkoz&aacute;s k&eacute;rhető a megadott el&eacute;rhetős&eacute;gek valamelyik&eacute;n. Adatai t&ouml;rl&eacute;s&eacute;t, m&oacute;dos&iacute;t&aacute;s&aacute;t b&aacute;rmikor k&eacute;rheti &iacute;r&aacute;sban. .</p>\r\n<p>A megrendel&eacute;ssel kezdődő elj&aacute;r&aacute;s sor&aacute;n a 2011. &eacute;vi CXII. t&ouml;rv&eacute;ny rendelkez&eacute;sei az ir&aacute;nyad&oacute;k, a szolg&aacute;ltat&oacute; adatv&eacute;delmi nyilatkozata a honlapon &eacute;rhető el.&nbsp;<em>K&eacute;sz&iacute;ts k&uuml;l&ouml;n men&uuml;pontot az adatv&eacute;delmi nyilatkozatnak!</em></p>\r\n<p><strong>15. Egy&eacute;b rendelkez&eacute;sek</strong></p>\r\n<p><em>Eg&eacute;sz&iacute;tsd ki&nbsp;az itt le&iacute;rtakat a&nbsp;saj&aacute;t tov&aacute;bbi rendelkez&eacute;seid alapj&aacute;n!</em></p>\r\n<p>A jelen &aacute;ltal&aacute;nos szerződ&eacute;si felt&eacute;telekben nem szab&aacute;lyozott k&eacute;rd&eacute;sekben a Ptk (2013.&eacute;vi V. t&ouml;rv&eacute;ny), fogyaszt&oacute;i szerződ&eacute;sekn&eacute;l a t&aacute;vollevők k&ouml;z&ouml;tt k&ouml;t&ouml;tt szerződ&eacute;sekről sz&oacute;l&oacute; 45/2014. korm&aacute;nyrendelet rendelkez&eacute;sei az ir&aacute;nyad&oacute;k.</p>\r\n</div>\r\n<div id=\"article-comments\"></div>', 1, '2025-09-25 13:59:37', '2025-09-25 14:11:07');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `vat_rate_id` int(11) NOT NULL DEFAULT 1,
  `unit_price_amount` decimal(10,2) DEFAULT NULL,
  `unit_price_unit` varchar(50) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sale_price_start_date` datetime DEFAULT NULL,
  `sale_price_end_date` datetime DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL COMMENT 'cm',
  `width` decimal(10,2) DEFAULT NULL COMMENT 'cm',
  `height` decimal(10,2) DEFAULT NULL COMMENT 'cm',
  `video_url` varchar(255) DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `category_id`, `manufacturer_id`, `name`, `slug`, `sku`, `description`, `short_description`, `price`, `vat_rate_id`, `unit_price_amount`, `unit_price_unit`, `sale_price`, `sale_price_start_date`, `sale_price_end_date`, `stock_quantity`, `image_path`, `length`, `width`, `height`, `video_url`, `is_visible`, `created_at`) VALUES
(8, 5, 1, 'Foglald le most kedvenc chili palán', 'foglald-le-most-kedvenc-chili-palan', '575745', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>', '2000.00', 1, '200.00', 'db', '1000.00', '2025-09-25 13:29:00', '2025-10-12 13:29:00', 10, 'public/uploads/products/1758878886_68d65ca62bc27_1.jpg', '122.00', '100.00', '100.00', 'https://youtu.be/i9N0Z7lyHlQ?si=ijn-JDHcBQ4VPpUU', 1, '2025-09-25 11:31:23'),
(9, 5, 3, 'Joomla weboldal készítés', 'joomla-weboldal-keszites', '', '', '', '100.00', 1, NULL, '', NULL, NULL, NULL, 100, 'public/uploads/products/1759307197_68dce5bd7de8d_Crème Brûlée.jpg', NULL, NULL, NULL, '', 1, '2025-09-25 13:06:59');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_attributes`
--

CREATE TABLE `product_attributes` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `product_attributes`
--

INSERT INTO `product_attributes` (`product_id`, `attribute_id`) VALUES
(8, 1),
(8, 2),
(8, 3),
(8, 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `sort_order`) VALUES
(12, 8, 'public/uploads/products/1758878912_68d65cc0a930a_2.jpg', 0),
(13, 8, 'public/uploads/products/1758878912_68d65cc0a9641_3.jpg', 0),
(14, 8, 'public/uploads/products/1758878912_68d65cc0a9907_4.jpg', 0),
(15, 8, 'public/uploads/products/1758878912_68d65cc0a9d06_5.jpg', 0),
(16, 8, 'public/uploads/products/1758878912_68d65cc0aa066_6.jpg', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_tags`
--

CREATE TABLE `product_tags` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `product_tags`
--

INSERT INTO `product_tags` (`product_id`, `tag_id`) VALUES
(8, 13),
(9, 14);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('bank_account_name', 'bxhndfn'),
('bank_account_number', 'fgfg345345345345'),
('bank_name', 'fjhfg'),
('bank_transfer_info', 'Kérjük, a közlemény rovatban tüntesd fel a rendelés azonosítóját a könnyebb beazonosíthatóság érdekében.'),
('cod_handling_fee_net', '500'),
('footer_col1_address', 'rbatgb sdf 2232 esgtsg'),
('footer_col1_description', 'dispifhpdsi9fdjfö9uüö jfguüj öeuöfjaö uföjwöaeufj wuuqa öfteuöua uödgsau jfgdsa'),
('footer_col1_email', 'sari.zoltan@cukorbetegreceptek.hu'),
('footer_col1_hours', '0-24'),
('footer_col1_phone', '223232323'),
('footer_col2_content', ' <ul><li><a href=\"#\">Link 1</a></li></ul>'),
('footer_col2_title', 'Quick Linkg'),
('footer_col3_content', '<li><a href=\"/aszf\">ÁSZF</a></li>'),
('footer_col3_title', 'Browse Category'),
('footer_col4_content', ' <ul><li><a href=\"#\">Link 1</a></li></ul>'),
('footer_col4_title', 'Support Center'),
('footer_col5_content', 'hjtshgggfs hshae5hrth ihfpjsadojf aifüiaüsks fiai ikfasfafaisüfias'),
('footer_col5_title', 'Get Mobile App'),
('footer_social_facebook', 'http://localhost/sp_store/'),
('footer_social_linkedin', 'http://localhost/sp_store/'),
('footer_social_twitter', 'http://localhost/sp_store/'),
('footer_social_youtube', 'http://localhost/sp_store/'),
('logo_image_path', 'uploads/logos/logo_1758872112.png'),
('logo_text', '<b>SP</b> Store'),
('logo_type', 'image'),
('payment_methods', '[{\"id\":\"cod\",\"name\":\"Utánvét\",\"info\":\"Fizetés a futárnál készpénzzel vagy bankkártyával.\",\"enabled\":true},{\"id\":\"bank_transfer\",\"name\":\"Banki átutalás\",\"info\":\"A díjbekérőt e-mailben küldjük.\",\"enabled\":true}]'),
('service_vat_rate_id', '1'),
('shipping_methods', '[{\"name\":\"Személyes átvétel\",\"cost\":0,\"enabled\":true},{\"name\":\"Házhozszállítás\",\"cost\":2100,\"enabled\":true}]'),
('size_unit', 'cm'),
('top_header_col1', '🚚 Ingyenes szállítás 20.fgjgh000 Ft felettfffjdfgdfj'),
('top_header_col2', '📞 Telefonszám: <a href=\"tel:+3612345678\">+3jhjh 1 234 5678</a>'),
('top_header_col3', '⏰ Nyitvatartás: H-P 9:00-17:0hgf0'),
('weight_unit', 'kg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `text_align` varchar(20) NOT NULL DEFAULT 'center',
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `slides`
--

INSERT INTO `slides` (`id`, `title`, `description`, `image_path`, `button_text`, `button_url`, `text_align`, `is_visible`, `sort_order`, `created_at`) VALUES
(4, 'gfhj', 'fdjdjz6jr', 'public/uploads/slider/1758782918_bk3.jpg', 'jdztdjz', '', 'center', 1, 0, '2025-09-24 13:01:44'),
(5, 'tzktzk', 'tuzktkk', 'public/uploads/slider/1758782891_bk3.jpg', 'jdztdjz', '', 'center', 1, 0, '2025-09-24 13:02:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`) VALUES
(1, 'erterw', NULL),
(2, 'ergeragr', NULL),
(3, 'hzeqzher', NULL),
(4, 'sgsdf', NULL),
(5, 'safgsdg', NULL),
(6, 'gsgsd', NULL),
(7, 'kicsi', NULL),
(8, 'nagy', NULL),
(9, 'új', NULL),
(10, 'fdhgdf', NULL),
(11, 'gfdsgs', NULL),
(12, 'gwsgds', NULL),
(13, 'ujcimke', 'ujcimke'),
(14, '212', '212');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Vásárló','Partner') NOT NULL DEFAULT 'Vásárló',
  `discount_percentage` int(3) DEFAULT NULL COMMENT 'Százalékos kedvezmény partnereknek',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `discount_percentage`, `created_at`) VALUES
(1, 'Test Admin', 'test@example.com', '$2y$10$mU2SP9Hk9QJv0ugSDQIiYe346zy0H3EyoRdvVP9r3B37BO3hiFxVm', 'Admin', NULL, '2025-09-24 10:27:49'),
(2, 'Sári Zoltán', 'info@spwebdesign.hu', '$2y$10$cHCEf4gTtBv.NZfRlpd4DerFJth2ocNGrYHUD1NJqCh9/.dqfPspm', 'Partner', 10, '2025-09-26 07:00:32');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vat_rates`
--

CREATE TABLE `vat_rates` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `rate` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `vat_rates`
--

INSERT INTO `vat_rates` (`id`, `name`, `rate`) VALUES
(1, '27% (Általános)', '27.00'),
(2, '18% (Kedvezményes)', '18.00'),
(3, '5% (Szuperkedvezményes)', '5.00');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- A tábla indexei `attribute_groups`
--
ALTER TABLE `attribute_groups`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- A tábla indexei `homepage_sections`
--
ALTER TABLE `homepage_sections`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- A tábla indexei `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- A tábla indexei `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- A tábla indexei `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`product_id`,`attribute_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- A tábla indexei `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- A tábla indexei `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`product_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- A tábla indexei `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- A tábla indexei `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `vat_rates`
--
ALTER TABLE `vat_rates`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `attribute_groups`
--
ALTER TABLE `attribute_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `homepage_sections`
--
ALTER TABLE `homepage_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT a táblához `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `vat_rates`
--
ALTER TABLE `vat_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `attribute_groups` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Megkötések a táblához `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_fk_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
