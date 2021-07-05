<?php 

namespace itrax\controllers;
use itrax\core\controller;
use itrax\models\categoryModel;

class dashboardController extends controller
{
    
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['user']))
        {
            exit("This Method Not Allowed");
        }
    }
    public function index()
    {
        $category = new categoryModel();
        $numberofcategory = $category->numCategory();
        $title = "Dashboard";
        return $this->view("dashboard/dashboard" , ['title' => $title , 'numberofcategory' => $numberofcategory]);
    }
}