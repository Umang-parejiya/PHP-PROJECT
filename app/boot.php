<?php
require_once __DIR__ . "/Controllers/Core/Base.php";
require_once __DIR__ . "/Models/Core/Request.php";
require_once __DIR__ . "/Controllers/Product.php";
require_once __DIR__ . "/Controllers/Category.php";
require_once __DIR__ . "/Controllers/Customer_group.php";
require_once __DIR__ . "/Controllers/Customer.php";
require_once __DIR__ . "/Controllers/Product_media.php";

class Boot extends Controllers_Core_Base{
    public static function init(){
        $request = new models_Core_Request();
        $controller = "Controllers_" . ucfirst($request->get("c","index"));
        $controllerObject = new $controller(); 
        $controllerObject->dispatch();
    }
}

?>