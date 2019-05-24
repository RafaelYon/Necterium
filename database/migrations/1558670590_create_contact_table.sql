CREATE TABLE contacts (
    `user_id` BIGINT UNSIGNED NOT NULL,
    `phone_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(256) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`, `phone_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;