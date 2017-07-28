-- sql
ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `group_id`;

-- 客服状态 0：登出，1：登录
ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `cs_status` int NOT NULL DEFAULT 0 AFTER `created_at`;

ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `cs_media_id` varchar(128) DEFAULT NULL AFTER `cs_status`;
