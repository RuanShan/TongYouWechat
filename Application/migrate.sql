-- sql
ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `group_id`;

-- 客服状态 0：登出，1：登录
ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `cs_status` int NOT NULL DEFAULT 0 AFTER `created_at`;

ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `cs_media_id` varchar(128) DEFAULT NULL AFTER `cs_status`;

ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `cs_qrcode` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '客服二维码';


-- sql
ALTER TABLE `tongyou_wechat_dev`.`wx_member`
ADD COLUMN `last_accessed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

-- 付款状态，0：未全款，1：已全款，备注：客户姓名， 输入激活码时强制工程师输入
ALTER TABLE `tongyou_wechat_dev`.`wx_machine`
ADD COLUMN `payment_status` INT(11) NOT NULL DEFAULT 0 AFTER `created_at`,
ADD COLUMN `memo` VARCHAR(128) NULL AFTER `payment_status`;
