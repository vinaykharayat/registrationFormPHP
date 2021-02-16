<?php

ini_set("file_uploads", '1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./dao/databaseDao.php');
require_once('./bean/userBean.php');
const SUCCESS_CODE = 200;
$dao = new databaseDao();
$dao->createConnection();
$profilePicUrl = uploadFile();
echo '<pre>';
print_r($profilePicUrl);
$newUser = new userBean(filter_input(INPUT_POST, "name"),
        filter_input(INPUT_POST, "username"),
        filter_input(INPUT_POST, "email"),
        filter_input(INPUT_POST, "dropdown"),
        filter_input(INPUT_POST, "checkboxes"),
        filter_input(INPUT_POST, "radio"),
        filter_input(INPUT_POST, "phone"),
        filter_input(INPUT_POST, "password"),
        $profilePicUrl);
$result = $dao->insertValues($newUser);
if ($result == SUCCESS_CODE) {
    header("Location: login.php");
    echo("success");
} else {
    echo 'failed';
}



function uploadFile() {
    $target_dir = "uploads/";
    $target_file = $target_dir . filter_input(INPUT_POST, "username"). ".";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["profilePicture"]["name"], PATHINFO_EXTENSION));
    $target_file .= $imageFileType;
    
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["profilePicture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["profilePicture"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    return "./".$target_file;
}
