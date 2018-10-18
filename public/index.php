<?php

define("ROOT",__DIR__."/../");
require(ROOT.'libs/function.php');

function load($class){
    $class = str_replace('\\','/',$class);
    require(ROOT.$class.'.php');
}
spl_autoload_register('load');

if(isset($_SERVER['PATH_INFO'])){
    $data = explode('/',$_SERVER['PATH_INFO']);
    $controller = ucfirst($data[1]);
    $action = $data[2];
}else {
    $controller = 'Index';
    $action = 'index';
}

$fullController = '\controllers\\'.$controller.'Controller';

$c = new $fullController;
$c->$action();