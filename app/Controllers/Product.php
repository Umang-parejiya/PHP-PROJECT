<?php
require_once __DIR__ . "/../Models/Product.php";
class Controllers_Product extends Controllers_Core_Base{
    public function indexAction(){
        $this->listAction();
    }
    public function listAction(){
        $productModel = new models_Product();
        $data = $productModel->getAll();

        $this->renderTemplate('product/list.phtml', ['data'=> $data]);
    }
    public function editAction(){
        $productModel = new models_Product();
        $id = $this->getRequest()->get('id');
        if($id){
            // $productModel->load($id);
            if(!$productModel->load($id)){
                throw new Exception("Invalid Product ID");
            }
        }
        $this->renderTemplate('product/edit.phtml', ['data'=> $productModel]);
    }
    public function saveAction(){
        $data = $this->getRequest()->post('product');
        $productModel = new models_Product();
        
        if(isset($data['product_id']) && $data['product_id']){
            if(!$productModel->load($data['product_id'])){
                throw new Exception("Invalid ID provided for update.");
            }
        }

        foreach($data as $key => $value){
            $productModel->$key = $value;
        }
        
        if(!$productModel->save()){
            throw new Exception("Failed to save the record.");
        }
        $this->redirect('list', 'product');
    }
    public function deleteAction(){
        $id = $this->getRequest()->get('id');
        if(!$id){
            throw new Exception("ID is missing.");
        }
        
        $productModel = new models_Product();
        if(!$productModel->load($id)){
            throw new Exception("Record not found.");
        }
        
        if(!$productModel->delete()){
            throw new Exception("Failed to delete the record.");
        }
        
        $this->redirect('list', 'product');
    }
    
}
?>