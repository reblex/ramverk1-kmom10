<?php

namespace reblex\Post;

use \Anax\Database\ActiveRecordModel;

/**
 * Post Model.
 */
class Post extends ActiveRecordModel
{

    protected $tableName = "Post";

    public $id;
    public $userId;
    public $datetime;
    public $content;
}
