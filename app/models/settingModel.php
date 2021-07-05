<?php

namespace itrax\models;

use itrax\core\db;

class settingModel extends db 
{
    public function GetSetting($key)
    {
        
        $setting = $this->all("SELECT `value` FROM `setting` WHERE `key` = '$key' ");
        return $setting[0]['value'];
    }

    public function UpdateSetting($value,$id)
    {
        $setting = $this->update($value,$id);
        return $setting;
    }
}