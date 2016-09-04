<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/08/2016
 * Time: 11:06
 */
require_once(realpath(dirname(__FILE__)) . '/Config.php');

use Config as Conf;
require_once (Conf::getManagerPath().'Manager.php');
require_once (Conf::getModelPath().'Student.php');
$manager=new Manager();
if(isset($_POST['search'])) {
    $name=$_POST['search'];
    $list=$manager->getList($name);
    echo"<table class='table'>";
    foreach ($list as $student){
        echo '<tr><td>' . $student['name'] . '</td><td>' . $student['surname'] . '</td><td>' . $student['country'] . '</td></tr>';
    }
    echo "</table>";
}
?>