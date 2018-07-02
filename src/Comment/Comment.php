<?php

namespace reblex\Comment;

use \Anax\Database\ActiveRecordModel;

/**
 * Comment Model.
 */
class Comment extends ActiveRecordModel
{

    protected $tableName = "comments";

    public $id;
    public $userId;
    public $content;
}
