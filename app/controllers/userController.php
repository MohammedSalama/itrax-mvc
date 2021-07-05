<?php 

namespace itrax\controllers;

use itrax\core\controller;
use itrax\models\userModel;
use itrax\core\helper;

class userController extends controller
{
    
    public function index()
    {
        $title = "Salama";
        return $this->view("home",['title' => $title]);
    }

    public function login()
    {
        session_start();
        if (isset($_SESSION['user']))
        {
            helper::redirect("category/index");
        }

        return $this->view("website/login");
    }

    public function loginReq()
    {
        session_start();
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new userModel();
        // echo '<pre>';
        // print_r( $user->GetUserInfoByEmailAndPassword($email,$password));
        // echo '</pre>';
        // die();
        $userData = $user->GetUserInfoByEmailAndPassword($email,$password);
        if (! empty($userData))
        {
            $_SESSION['user'] = $userData;
            $_SESSION['error'] = [];
            helper::redirect("dashboard/index");
        }
        else 
        {
            $_SESSION['error'][] = "User And Password Not Valid";
            helper::redirect("user/login");
        }
        
    }

    public function logout()
    {
        session_start();
        session_destroy();
        helper::redirect("user/login");
    }

}