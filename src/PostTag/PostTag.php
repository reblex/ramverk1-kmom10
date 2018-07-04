<?php

namespace reblex\PostTag;

use \Anax\Database\ActiveRecordModel;

/**
 * Post Model.
 */
class PostTag extends ActiveRecordModel
{

    protected $tableName = "PostTag";

    public $id;
    public $postId;
    public $tagId;
}
