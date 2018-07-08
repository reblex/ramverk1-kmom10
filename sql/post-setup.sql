-- Post made in the forum

DROP TABLE IF EXISTS `r1k10Post`;
CREATE TABLE `r1k10Post`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,   -- Unique Post ID
    `userId` INT NOT NULL,                          -- ID of User who posted
    `datetime` DATETIME,                            -- Datetime posted
    `content` VARCHAR(8000)                         -- Post content
);

INSERT INTO `r1k10Post` (`userId`, `datetime`, `content`) VALUES
    (1, "2018-06-29 18:44:12", "I think education is important! #education #government"),
    (2, "2018-06-30 12:20:01","I think #teslamotors is an **amazing** car company. They have really cool cars!"),
    (1, "2018-06-30 13:01:34","We need less #government!")
;
