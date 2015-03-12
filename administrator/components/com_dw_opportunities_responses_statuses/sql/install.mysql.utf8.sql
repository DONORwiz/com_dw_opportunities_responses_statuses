CREATE TABLE IF NOT EXISTS `#__dw_opportunities_responses_statuses` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`state` TINYINT(1)  NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`created` DATETIME NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL ,
`status` VARCHAR(255)  NOT NULL ,
`response_id` INT(11)  NOT NULL ,
`parameters` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

