-- Add publication workflow and scheduling to events.
-- Run this once against the bodarempc database.

ALTER TABLE `event`
    ADD COLUMN `status` ENUM('draft', 'published') NOT NULL DEFAULT 'published' AFTER `eventdescription`,
    ADD COLUMN `publish_start_at` DATETIME NULL AFTER `status`,
    ADD COLUMN `publish_end_at` DATETIME NULL AFTER `publish_start_at`;

-- Preserve the current website behavior for existing records.
UPDATE `event`
SET
    `status` = 'published',
    `publish_start_at` = '1970-01-01 00:00:00',
    `publish_end_at` = NULL;

ALTER TABLE `event`
    MODIFY COLUMN `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    MODIFY COLUMN `publish_start_at` DATETIME NOT NULL;

CREATE INDEX `idx_event_publication`
    ON `event` (`status`, `publish_start_at`, `publish_end_at`);
