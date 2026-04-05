<?php
require_once __DIR__ . "/../Models/Category.php";

class Controllers_Category extends Controllers_Core_Base
{
    public function indexAction()
    {
        $this->listAction();
    }

    public function listAction()
    {
        $categoryModel = new Models_Category();
        $data = $categoryModel->getAll();
        $this->renderTemplate('category/list.phtml', ['data' => $data]);
    }

    public function editAction()
    {
        $categoryModel = new Models_Category();
        $id = $this->getRequest()->get('id');

        if ($id) {
            if (!$categoryModel->load($id)) {
                throw new Exception("Invalid Category ID: " . $id);
            }
        }

        $this->renderTemplate('category/edit.phtml', ['data' => $categoryModel]);
    }

    public function saveAction()
    {
        $data = $this->getRequest()->post('category');
        $categoryModel = new Models_Category();

        if (isset($data['category_id']) && $data['category_id']) {
            if (!$categoryModel->load($data['category_id'])) {
                throw new Exception("Invalid ID provided for update: " . $data['category_id']);
            }
        }

        foreach ($data as $key => $value) {
            $categoryModel->$key = $value;
        }

        if (!$categoryModel->save()) {
            throw new Exception("Failed to save the category record.");
        }

        $this->redirect('list', 'category');
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->get('id');

        if (!$id) {
            throw new Exception("ID is missing for delete action.");
        }

        $categoryModel = new Models_Category();

        if (!$categoryModel->load($id)) {
            throw new Exception("Category record not found for ID: " . $id);
        }

        if (!$categoryModel->delete()) {
            throw new Exception("Failed to delete the category record.");
        }

        $this->redirect('list', 'category');
    }
}
?>
