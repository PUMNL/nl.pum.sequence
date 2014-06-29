CREATE TABLE IF NOT EXISTS `civicrm_pum_sequence` (
    `name`      varchar(100)          NOT NULL,
    `cur_value` bigint(20)   unsigned          DEFAULT 1,
    `min_value` bigint(20)   unsigned NOT NULL DEFAULT 1,
    `max_value` bigint(20)   unsigned NOT NULL DEFAULT 18446744073709551615,
    `increment` bigint(20)   unsigned NOT NULL DEFAULT 1,
    `cycle`     boolean               NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE='utf8_unicode_ci' COMMENT='nl.pum.sequence';
