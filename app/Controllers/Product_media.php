<?php
require_once __DIR__ . "/../Models/Product_media.php";
require_once __DIR__ . "/../Models/Product.php";
class Controllers_Product_media extends Controllers_Core_Base{
    public function indexAction(){
        $this->listAction();
    }
    public function listAction(){
        $mediaModel = new models_Product_media();
        $data = $mediaModel->getAll();

        $this->renderTemplate('product_media/list.phtml', ['data'=> $data]);
    }
    public function editAction(){
        $mediaModel = new models_Product_media();
        $id = $this->getRequest()->get('id');
        if($id){
            if(!$mediaModel->load($id)){
                throw new Exception("Invalid Media ID");
            }
        }
        
        $productModel = new models_Product();
        $products = $productModel->getAll();
        
        $this->renderTemplate('product_media/edit.phtml', ['data'=> $mediaModel, 'products' => $products]);
    }
    public function saveAction(){
        $data = $this->getRequest()->post('product_media');
        $mediaModel = new models_Product_media();
        
        if(isset($data['product_media_id']) && $data['product_media_id']){
            if(!$mediaModel->load($data['product_media_id'])){
                throw new Exception("Invalid ID provided for update.");
            }
        }

        foreach($data as $key => $value){
            $mediaModel->$key = $value;
        }
        
        if(!$mediaModel->save()){
            throw new Exception("Failed to save the record.");
        }
        $this->redirect('list', 'product_media');
    }
    public function deleteAction(){
        $id = $this->getRequest()->get('id');
        if(!$id){
            throw new Exception("ID is missing.");
        }
        
        $mediaModel = new models_Product_media();
        if(!$mediaModel->load($id)){
            throw new Exception("Record not found.");
        }
        
        if(!$mediaModel->delete()){
            throw new Exception("Failed to delete the record.");
        }
        
        $this->redirect('list', 'product_media');
    }
    
}
?>
