<?php
class Controllers_Core_Base
{
    protected $request = null;
    public function dispatch()
    {
        $this->request = $this->getRequest();
        $action = $this->request->get("a","index") . "Action";
        $this->$action();
    }
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }
    public function getRequest()
    {
        if(!$this->request){
            $this->request = new models_Core_Request();
            $this->setRequest($this->request);
            return $this->request;
        }
        return $this->request;
    }
    public function redirect($a=null,$c=null)
    {
        $request = $this->getRequest();
        if ($a !== null) {
            $action = $a;
        }else{
            $action = $request->get("a", "index");
        }

        if ($c !== null) {
            $controller = $c;
        }else{
            $controller = $request->get("c", "index");
        }

        header("Location: ?a=$action&c=$controller");
        exit();
    }
    public function renderTemplate($template, $data = [])
    {
        extract($data);
        $template = __DIR__ . '/../../templates/' . $template;

        if (!file_exists($template)) {
            die("Template not available: " . $template);
        }

        include $template;
    }

}

?>