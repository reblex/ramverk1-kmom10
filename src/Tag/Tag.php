<?php

namespace reblex\Tag;

use \Anax\Database\ActiveRecordModel;

/**
 * Post Model.
 */
class Tag extends ActiveRecordModel
{

    protected $tableName = "r1k10Tag";

    public $id;
    public $name;
}
