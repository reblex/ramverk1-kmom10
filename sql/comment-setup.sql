-- Comment of either Post or subcomment to other Comment

DROP TABLE IF EXISTS `Comment`;
CREATE TABLE `Comment`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,   -- Unique Comment ID
    `userId` INT NOT NULL,                          -- ID of User who posted
    `postId` INT NOT NULL,                          -- ID of Post
    `parentCommentId` INT,                          -- ID of parent Comment, if subcomment
    `datetime` DATETIME,
    `content` VARCHAR(800)
);

INSERT INTO `Comment` (`userId`, `postId`, `parentCommentId`, `content`) VALUES
    (1, 1, NULL, "I agree!"),
    (2, 2, NULL, "I would *LOVE* a tesla!."),
    (1, 2, 2, "Who wouldn't?? :D")
;
