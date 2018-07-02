USE anax;

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
