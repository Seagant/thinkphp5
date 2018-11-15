-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2018-11-14 03:31:43
-- 服务器版本： 5.7.23
-- PHP 版本： 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `mb`
--

-- --------------------------------------------------------

--
-- 表的结构 `mb_admin`
--

DROP TABLE IF EXISTS `mb_admin`;
CREATE TABLE IF NOT EXISTS `mb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) COLLATE utf8_bin NOT NULL,
  `nickname` varchar(12) COLLATE utf8_bin NOT NULL,
  `pass` varchar(64) COLLATE utf8_bin NOT NULL,
  `phone` bigint(11) NOT NULL,
  `sex` char(2) COLLATE utf8_bin NOT NULL,
  `age` smallint(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `auth` char(6) COLLATE utf8_bin NOT NULL DEFAULT 'low',
  `create_time` datetime DEFAULT NULL,
  `lastLogin_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mb_admin`
--

INSERT INTO `mb_admin` (`id`, `username`, `nickname`, `pass`, `phone`, `sex`, `age`, `status`, `auth`, `create_time`, `lastLogin_time`) VALUES
(1, 'SuperAdmin', '是超级用户', '21232f297a57a5a743894a0e4a801fc3', 15144558912, '男', 22, 1, 'high', NULL, '2018-11-13 14:49:27'),
(2, 'OceanT', 'O来报错', 'bfd59291e825b5f2bbf1eb76569f8fe7', 15620458007, '男', 22, 1, 'low', '2018-11-06 16:03:47', '2018-11-14 09:36:34'),
(3, 'seagant', 'O恩恩', '4ab9fc947653ae1b652e1fc1f4db31fc', 15680065007, '女', 23, 1, 'low', '2018-11-06 16:07:20', '2018-11-09 14:46:42');

-- --------------------------------------------------------

--
-- 表的结构 `mb_article`
--

DROP TABLE IF EXISTS `mb_article`;
CREATE TABLE IF NOT EXISTS `mb_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `author` varchar(12) COLLATE utf8_bin NOT NULL COMMENT '作者',
  `title` varchar(25) COLLATE utf8_bin NOT NULL,
  `content` varchar(300) COLLATE utf8_bin NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '文章状态0：删除；1：没删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mb_article`
--

INSERT INTO `mb_article` (`id`, `uid`, `author`, `title`, `content`, `create_time`, `update_time`, `status`) VALUES
(1, 3, 'O恩恩', '什么时候放假！', '好想放假！！真的好想放假！！！', '2018-11-09 13:50:04', NULL, 1),
(2, 3, 'O恩恩', 'This is Page', 'We are Family!We are Family!We are Family!', '2018-11-09 13:50:46', NULL, 1),
(3, 2, 'O来报错', 'You is Bitch', 'You is big-bitch , fuck you baby!', '2018-11-09 13:52:45', NULL, 1),
(4, 1, '是超级用户', '幸福其实很简单', '那日，商场门前，我在等人。旁边有一个举着一堆氢气球的叫卖人，瘦瘦弱弱，有种风一吹会被带走的感觉。恰逢一家三口走了过来，问价，“五元！”叫卖人高声回答。爸爸没说话，从口袋里掏出一沓零钱，抽出一张五元给了他。气球里，有时下热播的动画片《熊出没》里“熊二”造型的气球，爸爸示意孩子选这个，可孩子更喜欢一个鲨鱼造型的气球，爸爸妈妈尊重了孩子的意见，叫卖人熟练地解下气球，妈妈则将气球系在孩子的右手臂上，一家三口就这样走了。幸福可以很简单，就像刚才这样，只用五元钱，不用五分钟，满足了一家人，这里面有疼爱，有尊重，更有爸爸妈妈孩子在一起。', '2018-11-09 14:40:35', NULL, 1),
(5, 2, 'O来报错', ' 嫁个谁能过的好', '有人认为嫁一个有钱的人会幸福\r\n\r\n　　事实真是如此吗\r\n\r\n　　有钱的人必顶更多心思在工作上\r\n\r\n　　也许你衣食无忧\r\n\r\n　　每一天穿的富丽堂皇\r\n\r\n　　但是你男人却长期在外打拼\r\n\r\n　　你应对的却是空荡荡的房子\r\n\r\n　　你真觉得幸福吗', '2018-11-09 14:42:19', NULL, 1),
(6, 2, 'O来报错', 'This is sentence', 'While there is life there is hope. 一息若存，希望不灭。', '2018-11-09 14:44:50', NULL, 1),
(7, 2, 'O来报错', 'I am a slow walker', 'I am a slow walker,but I never walk backwards. (Abraham.Lincoln America)——我走得很慢，但是我从来不会后退。（亚伯拉罕.林肯美国）', '2018-11-09 14:46:01', NULL, 1),
(8, 3, 'O恩恩', 'You have great potential', 'Never underestimate your power to change yourself!\r\n永远不要低估你改变自我的能力！', '2018-11-09 14:52:10', NULL, 1),
(9, 3, 'O恩恩', 'Nothing is impossible', 'The man who has made up his mind to win will never say \"impossible \". (Bonaparte Napoleon ,French emperor )——凡是决心取得胜利的人是从来不说“不可能的”。( 法国皇帝 拿破仑. B.)', '2018-11-09 14:53:18', NULL, 1),
(10, 3, 'O恩恩', 'A man', 'A man is not old as long as he is seeking something. A man is not old until regrets take the place of dreams. (J. Barrymore)——只要一个人还有追求，他就没有老。直到后悔取代了梦想，一个人才算老。（巴里摩尔）', '2018-11-09 14:56:18', NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
