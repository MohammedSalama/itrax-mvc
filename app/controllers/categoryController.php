<?php 

namespace itrax\controllers;
use itrax\core\controller;
use itrax\models\categoryModel;
use itrax\core\helper;


class categoryController extends controller
{
    private $model;
    
    public function __construct()
    {
        $this->model = new categoryModel();
        session_start();
        if(empty($_SESSION['user']))
        {
            exit("This Method Not Allowed");
        }
    }
    public function index()
    {
        $categories = $this->model->getAllCategory();
        $title = "Category";
        return $this->view("dashboard/category/index" , ['title' => $title , 'categories' => $categories]);
    }

    public function add()
    {
        $title = "Add New Category";
        return $this->view("dashboard/category/add" , ['title' => $title]);
    }

    public function postadd()
    {
        if ($this->model->addNewCategory($_POST))
        {
            helper::redirect("category/index");
        }
    }

    public function delete($id)
    {
        if ($this->model->deleteCategory($id))
        {
            helper::redirect("category/index");
        }
    }

    public function update($id)
    {
        $category = $this->model->GetCategoryById($id);
        // echo '<pre>';
        // print_r($category);
        // echo '</pre>';
        // die();
        $title = "Update Category";
        return $this->view("dashboard/category/update",['title' => $title , 'category' => $category]);
    }

    public function postUpdate()
    {
        if ($this->model->updateCategory($_POST,$_POST['id']))
        {
            helper::redirect("category/index");
        }
    }

}