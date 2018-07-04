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
