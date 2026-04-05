<?php
require_once __DIR__ . "/Core/table.php";
class models_Product extends models_Core_Table{
    public $tableName = 'product';
    public $primaryKey = 'product_id';
}

?>