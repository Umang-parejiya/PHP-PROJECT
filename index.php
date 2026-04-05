<?php
require_once __DIR__ . "/app/boot.php";
class Mage{
    public static function init(){
        Boot::init();
    }
}
Mage::init();
?>