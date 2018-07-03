-- Post made in the forum

DROP TABLE IF EXISTS `Post`;
CREATE TABLE `Post`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,   -- Unique Post ID
    `userId` INT NOT NULL,                          -- ID of User who posted
    `datetime` DATETIME,                            -- Datetime posted
    `content` VARCHAR(800)                          -- Post content
);

INSERT INTO `Post` (`userId`, `content`) VALUES
    (1, "I think education is important! #education #government"),
    (2, "I think #teslamotors is an **amazing** car company. They have really cool cars!"),
    (3, "We need less #government!")
;
