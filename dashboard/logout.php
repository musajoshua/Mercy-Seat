<?php 
    require_once './../backend/functions.php';
    session_start();
    $auth = new Auth();
    $auth->logout();
    $auth->redirect('./../index.php');
?>