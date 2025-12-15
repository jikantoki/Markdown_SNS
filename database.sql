-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2025 年 12 月 15 日 03:46
-- サーバのバージョン： 5.7.44-log
-- PHP のバージョン: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
--

-- --------------------------------------------------------

--
-- テーブルの構造 `follow_list`
--

CREATE TABLE `follow_list` (
  `me_and_aite` varchar(256) NOT NULL COMMENT '左が右をフォローしている',
  `rand_id_me` varchar(256) NOT NULL COMMENT '自分側のID',
  `rand_id_aite` varchar(256) NOT NULL COMMENT '相手側のID',
  `unix_time` int(11) NOT NULL COMMENT 'フォローした時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `good_list`
--

CREATE TABLE `good_list` (
  `good_id` char(128) NOT NULL COMMENT 'ランダムな識別ID',
  `good_pusher_rand_id` text NOT NULL COMMENT 'グッドを押した人',
  `good_content` text NOT NULL COMMENT 'グッドされたコンテンツ',
  `good_unixtime` int(11) NOT NULL COMMENT '押した時間',
  `good_or_bad` text NOT NULL COMMENT 'グッドか？バッドか？'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `notif_list`
--

CREATE TABLE `notif_list` (
  `id` varchar(256) NOT NULL COMMENT '通知のID',
  `for_rand_id` text NOT NULL COMMENT '誰に送る通知か（rand_id）',
  `type` text NOT NULL COMMENT '通知の種類（何の通知か）',
  `unixtime` int(11) NOT NULL COMMENT '通知を送った時間',
  `var1` text COMMENT 'typeによって使い方を変える',
  `var2` text COMMENT 'typeによって使い方を変える',
  `var3` text COMMENT 'typeによって使い方を変える',
  `content_id` text COMMENT 'コンテンツのID',
  `from_rand_id` text COMMENT '誰による操作か？'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `sent_list`
--

CREATE TABLE `sent_list` (
  `sent_rand_id` varchar(64) NOT NULL COMMENT 'メッセージのID',
  `sent_owner` text NOT NULL COMMENT '投稿者',
  `sent_subowner` text COMMENT '共同編集者',
  `sent_message` text NOT NULL COMMENT 'メッセージ本文',
  `sent_time` int(11) NOT NULL COMMENT '投稿時間',
  `sent_genre` int(11) NOT NULL DEFAULT '0' COMMENT 'ジャンル',
  `sent_edited` int(11) NOT NULL DEFAULT '0' COMMENT '編集済みフラグ',
  `sent_sankou_link1` text COMMENT '参考URL',
  `sent_sankou_link2` text COMMENT '参考URL2',
  `sent_img_url1` text COMMENT '画像1',
  `sent_img_url2` text COMMENT '画像2',
  `sent_img_url3` text COMMENT '画像3',
  `sent_img_url4` text COMMENT '画像4',
  `place` text,
  `inyou` text COMMENT '引用元の投稿ID',
  `reply` text COMMENT '返信先の投稿ID',
  `ipAddress` text COMMENT '投稿時のIPアドレス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `server_info`
--

CREATE TABLE `server_info` (
  `access_cnt` bigint(64) NOT NULL DEFAULT '0' COMMENT 'アクセス数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `users_list`
--

CREATE TABLE `users_list` (
  `id` varchar(32) NOT NULL COMMENT 'ID',
  `mail` varchar(256) NOT NULL COMMENT 'メアド',
  `mail_open` int(11) NOT NULL COMMENT 'メアドを公開するフラグ',
  `name` text NOT NULL COMMENT '名前',
  `icon_url` text COMMENT 'アイコンURL',
  `twitter_id` text COMMENT 'Twitter ID',
  `session_id` varchar(64) NOT NULL DEFAULT '0' COMMENT 'セッションID',
  `pass` varchar(256) NOT NULL COMMENT 'パスワード',
  `status` int(11) DEFAULT NULL COMMENT 'アカウントの状態',
  `message` text COMMENT 'プロフィール文',
  `rand_id` varchar(48) NOT NULL COMMENT 'ランダムな仮ID',
  `idcard_open` int(11) NOT NULL DEFAULT '0' COMMENT '不明、なんかに使ってる',
  `certification` int(11) NOT NULL DEFAULT '0' COMMENT '本人確認済みフラグ',
  `verify_url` text COMMENT '本人確認用URL',
  `verify_url2` text COMMENT '本人確認用URL2',
  `area` int(11) NOT NULL DEFAULT '0' COMMENT '在住地方',
  `birth_y` int(11) DEFAULT NULL COMMENT '誕生年',
  `birth_m` int(11) DEFAULT NULL COMMENT '誕生月',
  `birth_d` int(11) DEFAULT NULL COMMENT '誕生日',
  `birth_open` int(11) NOT NULL DEFAULT '0' COMMENT '誕生日公開フラグ',
  `mac_json` text COMMENT 'MACアドレス（未使用）',
  `bgimg_url` varchar(256) DEFAULT '/img/bgimg.jpg',
  `unixtime` int(11) NOT NULL DEFAULT '1672531200' COMMENT 'アカウント作成時間',
  `otp` text,
  `custom_css` text COMMENT 'カスタムのCSS',
  `notif_last_unixtime` int(11) NOT NULL DEFAULT '0' COMMENT '最後に通知を見た時間',
  `ipAddress` text COMMENT 'アカウント登録時のIPアドレス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `follow_list`
--
ALTER TABLE `follow_list`
  ADD PRIMARY KEY (`me_and_aite`);

--
-- テーブルのインデックス `good_list`
--
ALTER TABLE `good_list`
  ADD PRIMARY KEY (`good_id`);

--
-- テーブルのインデックス `notif_list`
--
ALTER TABLE `notif_list`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `sent_list`
--
ALTER TABLE `sent_list`
  ADD PRIMARY KEY (`sent_rand_id`);

--
-- テーブルのインデックス `users_list`
--
ALTER TABLE `users_list`
  ADD PRIMARY KEY (`id`) USING BTREE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
