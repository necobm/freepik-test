DROP DATABASE IF EXISTS `lotr`;
CREATE DATABASE `lotr` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `lotr`;

DROP TABLE IF EXISTS `factions`;
CREATE TABLE `factions` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `faction_name` VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`,
    `description` TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`,
    PRIMARY KEY(`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB;

DROP TABLE IF EXISTS `creatures`;
CREATE TABLE `creatures` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `faction_id` INT DEFAULT NULL,
    `mission_id` INT DEFAULT NULL,
    `weapon_id` INT DEFAULT NULL,
    `name` VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `age` INT NOT NULL,
    `is_faction_leader` TINYINT(1) NOT NULL,
    UNIQUE INDEX UNIQ_A1F495645E237E06 (`name`),
    INDEX IDX_A1F49564BE6CAE90 (`mission_id`),
    INDEX IDX_A1F495644448F8DA (`faction_id`),
    INDEX IDX_A1F4956495B82273 (`weapon_id`),
    PRIMARY KEY(id)
)   DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;


DROP TABLE IF EXISTS `missions`;
CREATE TABLE `missions` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `description` TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `difficulty` INT NOT NULL,
    `finished` TINYINT(1) NOT NULL, PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

DROP TABLE IF EXISTS `weapons`;
CREATE TABLE `weapons` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `description` LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `portability` INT NOT NULL,
    `damage` INT NOT NULL,
    `resistance` INT NOT NULL, UNIQUE INDEX UNIQ_520EBBE15E237E06 (`name`),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `password` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `roles` LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT '(DC2Type:simple_array)',
    UNIQUE INDEX UNIQ_8D93D649F85E0677 (`username`),
    PRIMARY KEY(`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

DROP TABLE IF EXISTS `access_tokens`;
CREATE TABLE `access_tokens` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `token_value` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    `user_identification` VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
    UNIQUE INDEX UNIQ_58D184BCBEA95C75 (`token_value`),
    PRIMARY KEY(`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

