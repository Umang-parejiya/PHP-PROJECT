<?php
class models_Core_Request{
    public function get($key,$default=null){
        if(array_key_exists($key,$_GET)){
            return $_GET[$key];
        }
        return $default;
    }
    public function post($key,$default=null){
        if(array_key_exists($key,$_POST)){
            return $_POST[$key];
        }
        return $default;
    }

    public function input($key,$default=null){
        if(!$_GET[$key]){
            return $_GET[$key];
        }
        if(!$_POST[$key]){
            return $_POST[$key];
        }
        
    }
    public function has($key){
        if($_GET[$key] || $_POST[$key]){
            return true;
        }
        return false;
    }
    public function only($keys = []){
        $data = $_REQUEST;
        return array_intersect_key($data, array_flip($keys));
    }
    public function except($keys = []){
        $data = $_REQUEST;
        foreach($keys as $key){
            unset($data[$key]);
        }
        return $data;
    }
    public function header($key,$default=null){
        if(!$_SERVER['HTTP_'.$key]){
            return $default;
        }
        return $_SERVER['HTTP_'.$key];
    }
    public function headers(){
        return $_SERVER;
    }
    public function isPost(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            return true;
        }else{
            return false;
        }
    }
    public function isGet(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            return true;
        }else{
            return false;
        }
    }
}
?>