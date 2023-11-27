-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-07-29 18:53:22
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `collection`
--

CREATE TABLE `collection` (
  `collection_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='會員收藏多對多';

-- --------------------------------------------------------

--
-- 資料表結構 `discount_rate`
--

CREATE TABLE `discount_rate` (
  `discount_rate_id` int(11) NOT NULL,
  `discount_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `discount_rate`
--

INSERT INTO `discount_rate` (`discount_rate_id`, `discount_rate`) VALUES
(1, 0.9),
(2, 0.85),
(5, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(300) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `price` int(11) NOT NULL,
  `product_description` varchar(10000) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `specification` varchar(10000) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_type_list_id` int(11) NOT NULL,
  `discount_rate_id` int(1) DEFAULT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `product_description`, `specification`, `product_type_id`, `product_type_list_id`, `discount_rate_id`, `isValid`) VALUES
(1, '純檸檬磚', 320, '不用冷凍檸檬汁，常溫方便，加水即飲\r\n經過3道獨家滅菌技術製程，不用冷凍，常溫保存\r\n無濃縮還原、不加酸、不加水\r\n連皮帶籽取汁，完整檸檬原汁原味的天然酸味\r\n撕開包裝缺口即可快速沖泡，非常方便攜帶\r\n100% 台灣優利卡檸檬原汁\r\n100%台灣-不混充他國劣質檸檬\r\n100%認證-產銷履歷檸檬製成\r\n\r\n\r\n食用方法:\r\n[方法1]：撕開封口，直接倒入杯中，加入600~1000cc開水、氣泡水、飲料即可直接引用\r\n[方法2]：溫開水稀釋20倍使用(依個人喜好做調整)，並加入一小搓鹽，感冒前兆儘早飲用?\r\n[方法3]：可用於烘培、烹飪，泰式料理、檸檬魚、蝦最對味\r\n商品資訊', '內容：每顆25g，每盒12顆\r\n成分：檸檬原汁\r\n保存期限：常溫一年\r\n產地：台灣', 1, 3, 5, 1),
(2, '荔枝水果風味 | 衣索比亞 荔枝百合 G1 水洗 - 咖啡濾掛10入', 375, '| 咖啡豆介紹\r\n處理法：水洗處理\r\n風味： 野薑花、茉莉花、百香果、荔枝\r\n烘 焙：淺中焙\r\n\r\n\r\n| 咖啡風味實測\r\n 磨粉：可以聞到野薑花般的香氣\r\n\r\n 注水：加入水後香氣更濃郁般的甜味\r\n\r\n 高溫：先感受到萊荔枝的甜味\r\n\r\n 中溫：溫度略低可以感受到感受白糖甜感，以及若隱若現茉莉花香。\r\n\r\n 低溫：帶有熱帶水果&百香果風味，喝起來非常有魅力的一支咖啡。', '賞味期限：製造日期後 180 天\r\n保存方法：常溫\r\n內容物：100%阿拉比卡咖啡豆\r\n內容量：咖啡濾掛10入 (每包淨重11g)\r\n產地：台灣', 5, 19, 5, 1),
(3, ' 芋頭鹹蛋黃巴斯克 6吋', 1280, '最濃郁！!\r\n可以吃到芋頭塊的芋頭蛋糕 !\r\n人氣巴斯克蛋糕迷人焦香，除了香濃芋泥 加入大量『鹹蛋黃』甜鹹甜鹹古早滋味，在蛋糕表面以及蛋糕體中用了大量的蒸煮芋頭及鹹蛋黃，每一口都扎扎實實不馬虎。', '賞味期限 : 製造日期後 14 天 \r\n保存方法 : 冷凍\r\n1000g x 1', 2, 6, 1, 1),
(4, '紐澳良烤雞香料', 140, '紐奧良烤雞香料又名肯瓊香料，是美國南方的傳統風味，融合了西非、法國與西班牙移民的飲食文化。香料共和國使用獨特墨西哥香料配方作為基底，加入濃郁歐洲香草，成就一場視覺、味覺與嗅覺的感官盛宴。', '賞味期限:製造日期後 730 天\r\n保存方法:常溫、避免高溫、乾燥、避免陽光直射\r\n內容量:15g x 4', 4, 15, 5, 1),
(5, '拾玖茶屋 X 盧琴樹糖心酥 - 冬瓜檸檬', 790, '拾玖茶屋X盧琴樹糖心酥 最夯聯名 \r\n風靡手搖界の黃金比例 『冬瓜檸檬糖心酥』 酸溜酸溜~ 巨好吃 \r\n清檸酸爽微甜 冬瓜酥餅卡哩涮嘴 \r\n公道伯Toyz認證賀呷！', '賞味期限 : 製造日期後 30 天\r\n保存方法 : 常溫\r\n內容量 : 200g x 1', 3, 10, 5, 1),
(6, '【老張鮮物】炙燒骰子一口烏魚子', 790, '骰子烏魚子\r\n重磅野生一口烏魚子\r\n特殊手法製作.外酥內軟.\r\n新鮮不死鹹\r\n\r\n炙燒烏魚子,濃郁黏牙,香Q彈牙\r\nSGS國際檢驗無虞 投保南山千萬產品責任險\r\n\r\n老張真心話：保證特選過有別於一般市售的一口烏魚子，採用較高級別去5兩以上製作，較大的烏魚子品質口感會優於很多\r\n\r\n厚切看的見 不是用嘴巴講的,\r\n從研製/日曬法/切片/烤法/特殊滅菌真空包裝/樣樣講究\r\n\r\n口感不死鹹，口味剛剛好，厚切大塊食用口感佳，就是要讓大家吃到新鮮又好吃的烏魚子！', '賞味期限 : 製造日期後 365 天\r\n保存方法 :冷藏、冷凍\r\n內容量 : 100g／包', 5, 19, 5, 1),
(7, 'OJUICE芭樂檸檬冷壓綜合果蔬汁 (6入)', 390, 'OJUICE芭樂檸檬綜合純果汁\r\n以雲嘉南芭樂、屏東檸檬冷壓鮮榨\r\n每一口都喝得到濃郁芭樂顆粒口感\r\n\r\n芭樂清甜與綠檸檬微酸相佐　\r\n濃郁清爽絕不膩口!\r\n賣場熱銷好評不斷', '賞味期限 : 製造日期後 16 天\r\n保存方法 : 冷藏\r\n內容量 : 300ml x 6', 1, 3, 5, 1),
(15, '九蒸九曬蔘茸雞 | 藥膳料理 調理包 素食', 580, '對五行保養調配之古傳秘方，所有食材手工炮製，添加黨蔘、鹿茸等元氣藥材，無添加手工香料、防腐劑與色素，湯頭淡雅清香，營養補充之佳品。', '賞味期限 : 製造日期後 365 天\r\n保存方法 : 冷藏、冷凍\r\n內容量  : 100g x 6\r\n成分表：九蒸九曬熟地、當歸、安心枸杞、川芎、甘草、黑杜仲、安心貴妃棗、黨蔘 、蔘茸、肉蓯蓉、四製陳皮、清花桂、益母草、麥門冬、茯苓、黃耆、小茴、白?\r\n原物料產地：中國\r\n製程：台灣', 3, 11, 5, 1),
(16, 'CoCa MaMa 經典松露(含餡)巧克力系列 - 8入禮盒', 580, '松露(含餡)巧克力系列\r\n「松露(含餡)巧克力」的命名，是因為灑上可可粉時，外型酷似黑松露而得其名，但其實松露(含餡)巧克力並不含有任何的松露。後來，只要是不規則圓形的巧克力，皆被稱為「松露(含餡)巧克力」Chocolate Truffle。\r\n它以調溫巧克力包覆著內餡的形式呈現，本店使用咖啡、茶、不同風味的酒來呈現，一直深受大家喜愛。\r\n\r\n此系列的口味也以「大人」為主要的設計方向\r\n\r\n｜松露(含餡)巧克力系列　Truffle Chcocolate｜\r\n漫步愛爾蘭Baileys Irish Cream 苦甜牛奶甘那許、貝禮詩香甜酒\r\n黃金醇酒Scotch Whiskey 蘇格蘭威士忌酒心\r\n杏仁榛心 Hazelnut Paste 苦甜牛奶甘那許、炒糖杏仁角、研磨榛果醬、榛果粒\r\n經典原味 Classic Truffle 70%苦甜巧克力甘那許\r\n橙香甜酒 Cointreau Liqueur 苦甜巧克力甘那許、橙皮絲、君度橙酒\r\n天使干邑 Camus Brandy 70%苦甜巧克力甘那許、干邑白蘭地\r\n極品金萱 Jin Xuan Tea 苦甜巧克力甘那許、南投金萱茶\r\n香醇拿鐵 Latte Coffee 苦甜巧克力甘那許、咖啡', '賞味期限 : 製造日期後 7 天\r\n保存方法 : 冷藏、避免高溫、避免陽光直射\r\n內容量 : 8g x 8\r\n產地 : 台灣', 3, 11, 2, 1),
(22, 'BBQ嫩雞披薩(手工薄脆) 140g+/-6%', 299, '獨家手工技術製成道地美式披薩\r\n獨特手桿麵糰烘烤成薄脆的餅皮，再撒上法國進口100%天然牛乳製成香濃起司，搭配簡單的配料，成就經典道地美式風味。\r\n\r\n煙燻風味，濃厚迷人\r\n使用美式Barbecue醬加上洋蔥當作基底，加入特製醃醬烤雞，以及多種義式香草，最後撒上起司，鹹甜涮嘴！\r\n\r\n簡單加熱、快速享用\r\n烤箱：以240℃預熱，烘烤約8-10分鐘\r\n氣炸鍋：以180℃預熱，烘烤約5-6分鐘\r\n＊視各家電性能不同，時間及溫度會有所不同', '賞味期限 : 製造日期後 365 天\r\n保存方法 : 冷凍\r\n內容量 : 140g x 1', 3, 10, 5, 1),
(23, 'migoo 遇唰嘴-遇 脆脆 豬肉捲(原味)', 299, '我們把豬肉脆紙捲起來啦~~有別於一般豬肉脆紙造型，採用台灣豬黃金後腿肉，薄切成片再捲起來，獨特捲捲造型，融合營養豐富的杏仁片，吃起來更加香！酥！脆！\r\n招牌秘方，香氣爆棚，口感酥脆，一口咬下去就能聽到喀滋的聲音，香酥到讓人吃完整包才能罷休，欲罷不能的涮嘴，每口都是幸福滋味！是您聚會、休閒、旅行、加班的好伴侶。三種口味任選，滿足您每種心情的選擇！\r\n - 遇-脆脆·豬肉捲(原味)→經典鹹甜口感，香氣直衝鼻腔，萬年不敗好滋味！\r\n - 遇-脆脆·豬肉捲(海苔)→濃濃海味+香脆肉捲，老少咸宜，讓人一吃就愛上！\r\n - 遇-脆脆·豬肉捲(椒香)→多層次椒香口感，香氣爆棚！讓你越吃越開胃！', '賞味期限 : 製造日期後 180 天\r\n保存方法 : 常溫、避免高溫、乾燥、避免陽光直射\r\n商品產地 : 台灣', 3, 10, 5, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `product_img`
--

CREATE TABLE `product_img` (
  `product_img_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_img` varchar(300) CHARACTER SET big5 COLLATE big5_chinese_ci DEFAULT NULL,
  `showed_1st` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `product_img`
--

INSERT INTO `product_img` (`product_img_id`, `product_id`, `product_img`, `showed_1st`) VALUES
(117, 3, '1690459286.png', 0),
(121, 1, '1690601965.jpg', 0),
(122, 1, '1690602017.jpg', 0),
(123, 1, '1690602018.jpg', 0),
(124, 1, '1690602027.jpg', 0),
(129, 1, '1690603077.jpg', 0),
(130, 1, '1690603078.jpg', 0),
(132, 1, '1690603179.png', 0),
(133, 1, '1690603267.jpg', 0),
(134, 1, '1690603299.jpg', 0),
(135, 1, '1690603308.jpg', 0),
(136, 1, '1690603329.jpg', 0),
(137, 3, '1690619090.jpg', 0),
(138, 3, '1690619091.png', 0),
(139, 16, '1690619364.jpg', 0),
(140, 16, '1690619365.jpg', 0),
(142, 7, '1690639131.jpg', 0),
(144, 2, '1690639875.jpg', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `product_item`
--

CREATE TABLE `product_item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(300) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `price_range` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='商品篩選(tags)';

--
-- 傾印資料表的資料 `product_item`
--

INSERT INTO `product_item` (`item_id`, `item_name`, `price_range`) VALUES
(1, '低於300', 1),
(2, '300-500', 1),
(3, '500-1000', 1),
(4, '1000-1500', 1),
(5, '1500以上', 1),
(6, '鹹食', 0),
(7, '甜食', 0),
(8, '蛋奶素', 0),
(9, '無麩質', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `product_item_detail`
--

CREATE TABLE `product_item_detail` (
  `product_item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(11) NOT NULL,
  `product_type_name` varchar(300) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `isValid` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='商品大種類';

--
-- 傾印資料表的資料 `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type_name`, `isValid`) VALUES
(1, '飲品/沖泡類', 1),
(2, '烘焙食品/甜點', 1),
(3, '休閒零食', 1),
(4, '烹料料理', 1),
(5, '其他', 1),
(7, 'CChloe', 0),
(10, '測試', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `product_type_list`
--

CREATE TABLE `product_type_list` (
  `product_type_list_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_type_list_name` varchar(300) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `isValid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='商品小種類';

--
-- 傾印資料表的資料 `product_type_list`
--

INSERT INTO `product_type_list` (`product_type_list_id`, `product_type_id`, `product_type_list_name`, `isValid`) VALUES
(1, 1, '茶類', 1),
(2, 1, '咖啡/咖啡豆', 1),
(3, 1, '果汁', 1),
(4, 1, '醋/水果醋', 1),
(5, 1, '酒類', 1),
(6, 2, '蛋糕/派', 1),
(7, 2, '手工餅乾', 1),
(8, 2, '麵包/吐司', 1),
(9, 2, '奶酪/布丁/果凍', 1),
(10, 3, '零食', 1),
(11, 3, '糖果/巧克力', 1),
(12, 3, '果醬/抹醬', 1),
(13, 3, '水果乾', 1),
(14, 3, '堅果/穀物', 1),
(15, 4, '熟食/冷藏、冷凍食品', 1),
(16, 4, '米/麵條', 1),
(17, 4, '調理包/料理包', 1),
(18, 4, '調味料/醬料', 1),
(19, 5, '其他', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`collection_id`);

--
-- 資料表索引 `discount_rate`
--
ALTER TABLE `discount_rate`
  ADD PRIMARY KEY (`discount_rate_id`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_type_id` (`product_type_id`),
  ADD KEY `product_type_list_id` (`product_type_list_id`),
  ADD KEY `discount_rate_id` (`discount_rate_id`);

--
-- 資料表索引 `product_img`
--
ALTER TABLE `product_img`
  ADD PRIMARY KEY (`product_img_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 資料表索引 `product_item`
--
ALTER TABLE `product_item`
  ADD PRIMARY KEY (`item_id`);

--
-- 資料表索引 `product_item_detail`
--
ALTER TABLE `product_item_detail`
  ADD PRIMARY KEY (`product_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `item_id` (`item_id`);

--
-- 資料表索引 `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- 資料表索引 `product_type_list`
--
ALTER TABLE `product_type_list`
  ADD PRIMARY KEY (`product_type_list_id`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `collection`
--
ALTER TABLE `collection`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `discount_rate`
--
ALTER TABLE `discount_rate`
  MODIFY `discount_rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_img`
--
ALTER TABLE `product_img`
  MODIFY `product_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_item`
--
ALTER TABLE `product_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_item_detail`
--
ALTER TABLE `product_item_detail`
  MODIFY `product_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_type_list`
--
ALTER TABLE `product_type_list`
  MODIFY `product_type_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`product_type_list_id`) REFERENCES `product_type_list` (`product_type_list_id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`discount_rate_id`) REFERENCES `discount_rate` (`discount_rate_id`);

--
-- 資料表的限制式 `product_img`
--
ALTER TABLE `product_img`
  ADD CONSTRAINT `product_img_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- 資料表的限制式 `product_item_detail`
--
ALTER TABLE `product_item_detail`
  ADD CONSTRAINT `product_item_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `product_item_detail_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `product_item` (`item_id`);

--
-- 資料表的限制式 `product_type_list`
--
ALTER TABLE `product_type_list`
  ADD CONSTRAINT `product_type_list_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
