<?php 

namespace itrax\controllers;
use itrax\core\controller;
use itrax\models\settingModel;
use itrax\core\helper;

class settingController extends controller
{
    
    public function __construct()
    {
        session_start();
        if(empty($_SESSION['user']))
        {
            exit("This Method Not Allowed");
        }
    }
    public function theme()
    {
        $theme = new settingModel();
        $theme_key = $theme->GetSetting('theme');
        $title = "Dashboard";
        return $this->view("setting/theme" , ['title' => $title , 'theme_key' => $theme_key]);
    }

    public function posttheme()
    {
        $data = [
            'value' => $_POST['value']
        ];
        
        $theme = new settingModel();
        $theme_res = $theme->UpdateSetting($data,1);
        if ($theme_res)
        {
            helper::redirect("setting/theme");
        }
    }

    public function setting()
    {
        $theme = new settingModel();
        $headline = $theme->GetSetting("headline");
        $title = "Setting";
        return $this->view("setting/setting" , ['title' => $title , 'headline' => $headline]);
    }

    public function postsetting()
    {
        $data = [
            'value' => $_POST['value']
        ];
        
        $theme = new settingModel();
        $theme_res = $theme->UpdateSetting($data,2);
        if ($theme_res)
        {
            helper::redirect("setting/setting");
        }
    }
}