<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(dirname(getcwd()) . '/bean/userBean.php');
require_once (dirname(getcwd()) . '/dao/databaseDao.php');
const SUCCESS_CODE = 200;
const FAILURE_CODE = -1;
$dao = new databaseDao();
$dao->createConnection();

/*
 * *****************************************************
 * Performs delete or update besed of user button click
 * *****************************************************
 */
if (filter_input(INPUT_POST, "action") == "delete") {
    $result = $dao->deleteRow(filter_input(INPUT_POST, "userid"));
    if ($result == SUCCESS_CODE) {
        echo SUCCESS_CODE;
    } else {
        echo FAILURE_CODE;
    }
} else {
    $user = new userBean(filter_input(INPUT_POST, "fullName"),
            filter_input(INPUT_POST, "username"),
            filter_input(INPUT_POST, "email"),
            filter_input(INPUT_POST, "experience"),
            filter_input(INPUT_POST, "profile"),
            filter_input(INPUT_POST, "gender"),
            filter_input(INPUT_POST, "phone"),
            filter_input(INPUT_POST, "password"),
            filter_input(INPUT_POST, "profilePictureUrl"));
    $result = $dao->updateValues($user, filter_input(INPUT_POST, "userid"));
    if ($result == SUCCESS_CODE) {
        echo SUCCESS_CODE;
    } else {
        echo FAILURE_CODE;
    }
}


