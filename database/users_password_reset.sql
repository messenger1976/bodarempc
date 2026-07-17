ALTER TABLE `users`
  ADD COLUMN `reset_token` VARCHAR(64) NULL DEFAULT NULL AFTER `password`,
  ADD COLUMN `reset_expiry` DATETIME NULL DEFAULT NULL AFTER `reset_token`,
  ADD UNIQUE KEY `users_reset_token_unique` (`reset_token`);
