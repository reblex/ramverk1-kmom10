DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `userId` INT NOT NULL,
    `datetime` DATETIME,
    `content` VARCHAR(800)
);

DELETE FROM `comments`;
INSERT INTO `comments` (`userId`, `content`) VALUES
(1, 'Hejsan svejsan.'),
(2, 'Jag gillar bord.')
;
