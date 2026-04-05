<?php
require_once __DIR__ . "/Core/table.php";

class models_Category extends models_Core_Table
{
    public $tableName = 'category';
    public $primaryKey = 'category_id';
}
?>
