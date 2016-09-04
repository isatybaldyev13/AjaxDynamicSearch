<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/08/2016
 * Time: 11:01
 */
require_once(realpath(dirname(__FILE__)) . '/../Config.php');
use Config as Conf;

require_once (Conf::getDatabasePath() . 'MyDataAccessPDO.php');
require_once (Config::getModelPath().'Student.php');
class Manager extends MyDataAccessPDO
{
    //This function return result
    public function getList($name){
        try{
            $list = $this->getRecordsByUserQuery("SELECT * FROM student WHERE name LIKE '%".$name."%'");
            return $list;
        }
        catch (Exception $e){
            throw $e;
        }
    }

}