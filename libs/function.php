<?php

function view($fileView,$data=[]){

    // 把数组转化为变量
    extract($data);

    $fileView = str_replace('.','/',$fileView);
    
    require(ROOT.'views/'.$fileView.'.html');
}

function back(){

    header("Location:".$_SERVER['HTTP_REFERER']);
}

function redirect($route){

    header("Location:".$route);
    exit;
}