<?php

namespace reblex\Tag;

use \Anax\Database\ActiveRecordModel;

/**
 * Post Model.
 */
class Tag extends ActiveRecordModel
{

    protected $tableName = "Tag";

    public $id;
    public $name;
}
