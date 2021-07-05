<?php 

namespace itrax\controllers;
use itrax\core\controller;
use itrax\models\settingModel;
use itrax\models\categoryModel;

class homeController extends controller
{
    public function index()
    {
        $setting = new settingModel();
        $theme = $setting->GetSetting('theme');
        $headline = $setting->GetSetting('headline');
        $category = new categoryModel();
        $menu = $category->getAllCategory();
        // echo '<pre>';
        // print_r($menu);
        // echo '</pre>';
        // die();

        
        $title = "Muhammed";

        // $headline = 
        return $this->view("website/".$theme."/index" , ['title' => $title,'headline' => $headline , 'menu' => $menu]);
    }
}