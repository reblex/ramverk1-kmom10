<?php

namespace reblex\Comment;

use \Anax\Database\ActiveRecordModel;

/**
 * Comment Model.
 */
class Comment extends ActiveRecordModel
{

    protected $tableName = "Comment";

    public $id;
    public $userId;
    public $postId;
    public $parentCommentId;
    public $datetime;
    public $content;
}
