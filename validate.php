<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./dao/databaseDao.php');
$username = filter_input(INPUT_GET, "username");
$emailInput = filter_input(INPUT_GET, "email");
$phoneInput = filter_input(INPUT_GET, "phone");
const SUCCESS_CODE = 200;

$dao = new databaseDao();
if ($dao->createConnection() == SUCCESS_CODE) {
    initiateValidation();
} else {

    die($dao->createConnection());
}

/*
 * ****************************************************
 * Checks for existing username, email or phone number
 * ****************************************************
 */

function initiateValidation() {

    if ($GLOBALS["username"] != null) {
        checkAvalability("username", $GLOBALS['username']);
    }

    if ($GLOBALS["emailInput"] != null) {

        checkAvalability("email", $GLOBALS['emailInput']);
    }

    if ($GLOBALS["phoneInput"] != null) {

        checkAvalability("phone", $GLOBALS['phoneInput']);
    }
}

function checkAvalability($columnName, $valueToCheck) {
    $dao = &$GLOBALS["dao"];
    $result = $dao->checkAvalability($columnName, $valueToCheck);
    if ($result == SUCCESS_CODE) {
        echo "nExist";
    } else {
        echo "exist";
    }
}
