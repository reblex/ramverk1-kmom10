-- Tags used to sort Posts.

DROP TABLE IF EXISTS `Tag`;
CREATE TABLE `Tag`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(20)
);

INSERT INTO `Tag` (`name`) VALUES
    ("education"),
    ("government"),
    ("teslamotors")
;
