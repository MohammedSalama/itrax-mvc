<?php 

namespace itrax\core;

class helper 
{
    static function redirect($path)
    {
        header("location: ".URL."/".$path);
    }

    static function url($path)
    {
        return URL.$path;
    }
}