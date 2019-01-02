<?php

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
session_start();
$obj_admin = new Admin();
$obj_admin->logout_reviewer();