<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./bean/userBean.php');
require_once ('./dao/databaseDao.php');
const SUCCESS_CODE = 200;
const FAILURE_CODE = -1;
$dao = new databaseDao();
$dao->createConnection();
$userEmail = filter_input(INPUT_POST, 'email');
$userPassword = filter_input(INPUT_POST, 'password');
$result = $dao->verifyUserDetails($userEmail, $userPassword);
if ($result == SUCCESS_CODE) {
    echo 'exist';
} else {
    echo 'nExist';
}

