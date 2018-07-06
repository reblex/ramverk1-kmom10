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
    (1, 2, 2, "Who wouldn't?? :D"),
    (1, 2, NULL, "Model S is my favourite!"),
    (2, 2, 3, "I know right :P")

;

-- Post made in the forum

DROP TABLE IF EXISTS `Post`;
CREATE TABLE `Post`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,   -- Unique Post ID
    `userId` INT NOT NULL,                          -- ID of User who posted
    `datetime` DATETIME,                            -- Datetime posted
    `content` VARCHAR(8000)                         -- Post content
);

INSERT INTO `Post` (`userId`, `datetime`, `content`) VALUES
    (1, "2018-06-29 18:44:12", "I think education is important! #education #government"),
    (2, "2018-06-30 12:20:01","I think #teslamotors is an **amazing** car company. They have really cool cars!"),
    (1, "2018-06-30 13:01:34","We need less #government!")
;

-- Link Table between Tags and Posts.
-- A tag can apply to multiple Tags, and Posts can have multiple Tags.

DROP TABLE IF EXISTS `PostTag`;
CREATE TABLE `PostTag`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,   -- Unique PostTags ID
    `postId` INT NOT NULL,                          -- Post ID
    `tagId` INT NOT NULL                            -- Tag ID
);

INSERT INTO `PostTag` (`postId`, `tagId`) VALUES
    (1, 1), -- Post 1 has the Tag #education
    (1, 2), -- Post 1 has the Tag #government
    (2, 3), -- Post 2 has the Tag #teslamotors
    (3, 2)  -- Post 3 has the Tag #government
;

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

SET NAMES utf8;


DROP TABLE IF EXISTS User;
CREATE TABLE User (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(80) UNIQUE NOT NULL,
    `email` VARCHAR(225) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `admin` INTEGER NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `User` (`username`, `email`, `password`, `admin`) VALUES
('user', 'user@user.com', '$2y$10$0fwmQmv5iZP86a/yPnDj0uoH8W.n8IhhbbePs2w8KRrtPeqeD7lqi', 0),
('admin', 'admin@admin.com', '$2y$10$jQGcqEbKEx.IxbBsld.cBuJ1amDPy8QP8eELsyU9qD2np9cMAmYDa', 1)
;
