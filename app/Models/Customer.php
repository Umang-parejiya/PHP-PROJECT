<?php
require_once __DIR__ . "/Core/table.php";
class models_Customer extends models_Core_Table{
    public $tableName = 'customer';
    public $primaryKey = 'customer_id';
}

?>