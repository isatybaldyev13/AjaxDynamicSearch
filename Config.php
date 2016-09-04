<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09/06/2016
 * Time: 15:30
 */
class Config {


    const SGBD_HOST_NAME = 'localhost';
    const SGBD_DATABASE_NAME = 'Students';
    const SGBD_USERNAME = 'root';
    const SGBD_PASSWORD = '';
    
    public static function getDatabasePath(){
        return realpath(dirname( __FILE__ )) .'/Database/';
    }

    public static function getManagerPath(){
        return realpath(dirname( __FILE__ )).'/Manager/';
    }

    public static function getModelPath(){
        return realpath(dirname( __FILE__ )) .'/Model/';
    }
    public static function getFormPath(){
        return realpath(dirname( __FILE__ )) .'/Forms/';
    }
    public static function getPagesPath(){
        return realpath(dirname( __FILE__ )) .'/Pages/';
    }
    public static function getImagesPath(){
        return realpath(dirname( __FILE__ )) .'/Images/';
    }
}