-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- 主机： 127.0.0.1
-- 生成日期： 2026-05-08 05:07:34
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- 数据库： `onlinecarsale`

-- 表的结构 `cars`
DROP TABLE IF EXISTS `cars`;
CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL COMMENT '车辆主键id',
  `seller_id` int(11) NOT NULL COMMENT '卖家id（外键）',
  `color` varchar(30) NOT NULL COMMENT '颜色',
  `model` varchar(100) NOT NULL COMMENT '型号（索引）',
  `year` int(11) NOT NULL COMMENT '生产年份（索引）',
  `location` varchar(255) NOT NULL COMMENT '地址',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `image_path` varchar(255) DEFAULT NULL COMMENT '图片路径'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 表的结构 `sellers`
DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL COMMENT '序号、主键',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `fullname` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `address` varchar(100) DEFAULT NULL COMMENT '地址',
  `id_card` varchar(30) DEFAULT NULL COMMENT '身份证号',
  `id_photo` varchar(255) DEFAULT NULL COMMENT '身份证图片路径',
  `seller_type` varchar(20) DEFAULT NULL COMMENT '卖家类型',
  `create_time` timestamp NULL DEFAULT current_timestamp() COMMENT '注册时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 表的索引 `cars`
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `model` (`model`),
  ADD KEY `year` (`year`);

-- 表的索引 `sellers`
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `password` (`password`),
  ADD KEY `create_time` (`create_time`);

-- 使用表AUTO_INCREMENT
ALTER TABLE `cars` MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '车辆主键id';
ALTER TABLE `sellers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号、主键';

-- 限制表
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

-- 插入测试账号（可直接登录）
INSERT INTO `sellers` (`username`, `password`, `fullname`, `phone`, `email`, `address`, `id_card`, `id_photo`, `seller_type`)
VALUES ('testuser', '123456', 'Test User', '123456789', 'test@test.com', 'Test Address', '123456789012345678', '', 'personal');

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;