<?php

namespace reblex\PostTag;

use \Anax\Database\ActiveRecordModel;

/**
 * Post Model.
 */
class PostTag extends ActiveRecordModel
{

    protected $tableName = "r1k10PostTag";

    public $id;
    public $postId;
    public $tagId;
}
