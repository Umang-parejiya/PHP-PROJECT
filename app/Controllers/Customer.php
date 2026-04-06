<?php
require_once __DIR__ . "/../Models/Customer.php";
require_once __DIR__ . "/../Models/Customer_group.php";
class Controllers_Customer extends Controllers_Core_Base{
    public function indexAction(){
        $this->listAction();
    }
    public function listAction(){
        $customerModel = new models_Customer();
        $data = $customerModel->getAll();

        $this->renderTemplate('customer/list.phtml', ['data'=> $data]);
    }
    public function editAction(){
        $customerModel = new models_Customer();
        $id = $this->getRequest()->get('id');
        if($id){
            if(!$customerModel->load($id)){
                throw new Exception("Invalid Customer ID");
            }
        }
        $customerGroupModel = new models_Customer_group();
        $customerGroups = $customerGroupModel->getAll();
        
        $this->renderTemplate('customer/edit.phtml', ['data'=> $customerModel, 'customerGroups' => $customerGroups]);
    }
    public function saveAction(){
        $data = $this->getRequest()->post('customer');
        $customerModel = new models_Customer();
        
        if(isset($data['customer_id']) && $data['customer_id']){
            if(!$customerModel->load($data['customer_id'])){
                throw new Exception("Invalid ID provided for update.");
            }
        }

        foreach($data as $key => $value){
            $customerModel->$key = $value;
        }
        
        if(!$customerModel->save()){
            throw new Exception("Failed to save the record.");
        }
        $this->redirect('list', 'customer');
    }
    public function deleteAction(){
        $id = $this->getRequest()->get('id');
        if(!$id){
            throw new Exception("ID is missing.");
        }
        
        $customerModel = new models_Customer();
        if(!$customerModel->load($id)){
            throw new Exception("Record not found.");
        }
        
        if(!$customerModel->delete()){
            throw new Exception("Failed to delete the record.");
        }
        
        $this->redirect('list', 'customer');
    }
    
}
?>




