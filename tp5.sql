CREATE TABLE `think_sensitive` (
                                   `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                   `words` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '敏感词',
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   `updated_at` timestamp NULL DEFAULT NULL,
                                   `deleted_at` timestamp NULL DEFAULT NULL,
                                   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='敏感词';

CREATE TABLE `think_user` (
                              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                              `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
                              `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
                              `status` int(11) DEFAULT NULL COMMENT '状态 0-正常 1-黑名单',
                              `ban_until` timestamp NULL DEFAULT NULL COMMENT '命名单截止时间',
                              `created_at` timestamp NULL DEFAULT NULL,
                              `updated_at` timestamp NULL DEFAULT NULL,
                              `deleted_at` timestamp NULL DEFAULT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户表';