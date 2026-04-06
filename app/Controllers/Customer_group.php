<?php
require_once __DIR__ . "/../Models/Customer_group.php";
class Controllers_Customer_group extends Controllers_Core_Base{
    public function indexAction(){
        $this->listAction();
    }
    public function listAction(){
        $customerGroupModel = new models_Customer_group();
        $data = $customerGroupModel->getAll();

        $this->renderTemplate('customer_group/list.phtml', ['data'=> $data]);
    }
    public function editAction(){
        $customerGroupModel = new models_Customer_group();
        $id = $this->getRequest()->get('id');
        if($id){
            // $customerGroupModel->load($id);
            if(!$customerGroupModel->load($id)){
                throw new Exception("Invalid Customer Group ID");
            }
        }
        $this->renderTemplate('customer_group/edit.phtml', ['data'=> $customerGroupModel]);
    }
    public function saveAction(){
        $data = $this->getRequest()->post('customer_group');
        $customerGroupModel = new models_Customer_group();
        
        if(isset($data['customer_group_id']) && $data['customer_group_id']){
            if(!$customerGroupModel->load($data['customer_group_id'])){
                throw new Exception("Invalid ID provided for update.");
            }
        }

        foreach($data as $key => $value){
            $customerGroupModel->$key = $value;
        }
        
        if(!$customerGroupModel->save()){
            throw new Exception("Failed to save the record.");
        }
        $this->redirect('list', 'customer_group');
    }
    public function deleteAction(){
        $id = $this->getRequest()->get('id');
        if(!$id){
            throw new Exception("ID is missing.");
        }
        
        $customerGroupModel = new models_Customer_group();
        if(!$customerGroupModel->load($id)){
            throw new Exception("Record not found.");
        }
        
        if(!$customerGroupModel->delete()){
            throw new Exception("Failed to delete the record.");
        }
        
        $this->redirect('list', 'customer_group');
    }
    
}
?>




