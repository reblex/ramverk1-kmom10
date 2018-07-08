-- Tags used to sort Posts.

DROP TABLE IF EXISTS `r1k10Tag`;
CREATE TABLE `r1k10Tag`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(20)
);

INSERT INTO `r1k10Tag` (`name`) VALUES
    ("education"),
    ("government"),
    ("teslamotors")
;
