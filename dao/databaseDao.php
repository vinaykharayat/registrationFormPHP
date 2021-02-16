<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once(dirname(getcwd()).'/bean/userBean.php');

class databaseDao {

    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "cedcoss";
    const SUCCESS_CODE = 200;
    const FAILURE_CODE = -1;

    private $conn;

    /*
     * *******************************
     * Creates connection to database
     * *******************************
     */

    function createConnection() {
        $conn = &$GLOBALS['conn'];
        $conn = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASE);
        if ($conn->connect_errno) {
            return $conn->connect_error;
        } else {

            return self::SUCCESS_CODE;
        }
    }

    /*
     * ********************************************************************
     * Checks whether a value exist in a particular column
     * If not exists, it sends a response code of 200 else it will send -1
     * ********************************************************************
     */

    function checkAvalability($columnName, $value) {
        $conn = &$GLOBALS['conn'];
        $query = "select * from users where `$columnName` = '$value'";
        $result = $conn->query($query);
        if ($result->num_rows == 0) {
            return self::SUCCESS_CODE;
        } else {
            return self::FAILURE_CODE;
        }
    }

    /*
     * ****************************************************
     * Inserts value to table(users) using userBean object
     * ****************************************************
     */

    function insertValues($user) {
        $conn = &$GLOBALS['conn'];
        $query = "insert into users(`fullName`, `username`, `email`,`password`, `experience`, `profile`, `gender`, `phone`, `profilePicture`) values(" . "'" . $user->getFullName() . "','" . $user->getUsername() . "', '" . $user->getEmail() . "', '" . $user->getPassword() . "', '" . $user->getExperience() . "', '" . $user->getProfile() . "', '" . $user->getGender() . "', '" . $user->getPhone() . "', '" . $user->getProfilePicture() . "')";
        $result = $conn->query($query);
        print_r($result);

        if ($result > 0) {
            return self::SUCCESS_CODE;
        } else {
            return self::FAILURE_CODE;
        }
    }

    /*
     * ***********************************
     * Gets all the data from table(users)
     * ***********************************
     */

    function getAllData() {
        $conn = &$GLOBALS['conn'];
        $query = "select * from users";
        $results = $conn->query($query);
        return $results;
    }

    /*
     * ********************************************
     * Updates value in database using primary key
     * ********************************************
     */

    function updateValues($user, $primaryKey) {

        $conn = &$GLOBALS['conn'];
        $query = "update users set `fullName` = '" . $user->getFullName() . "', `username` = '" . $user->getUsername() . "', `email` = '" . $user->getEmail() . "', `password` = '" . $user->getPassword() . "', `experience`= '" . $user->getExperience() . "', `profile` = '" . $user->getProfile() . "', `gender` = '" . $user->getGender() . "', `phone` = '" . $user->getPhone() . "', `profilePicture` = '" . $user->getProfilePicture() .  "' where `userId`='" . $primaryKey . "';";
        $results = $conn->query($query);
        if ($results > 0) {
            return self::SUCCESS_CODE;
        } else {
            return self::FAILURE_CODE;
        }
    }

    /*
     * ***********************************
     *      Deletes a row in database
     * ***********************************
     */

    function deleteRow($primaryKey) {
        $conn = &$GLOBALS['conn'];
        $query = "DELETE from users WHERE `userid`='$primaryKey'";
        $results = $conn->query($query);
        if ($results > 0) {
            return self::SUCCESS_CODE;
        } else {
            return self::FAILURE_CODE;
        }
    }

    function verifyUserDetails($userEmail, $userPassword) {
        $conn = &$GLOBALS['conn'];
        $query = "Select * from users where `email`='$userEmail' AND `password` = '$userPassword'";
        $results = $conn->query($query);
        if ($results > 0) {
            return self::SUCCESS_CODE;
        } else {
            return self::FAILURE_CODE;
        }
    }

}
