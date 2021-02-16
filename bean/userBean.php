<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class userBean{
    private $fullName;
    private $username;
    private $email;
    private $experience;
    private $profile;
    private $gender;
    private $phone;
    private $password;
    private $profilePicture;
    private $profilePictureUrl;
            
    function __construct($fullName, $username, $email, $experience, $profile, $gender, $phone, $password, $profilePicture) {
        $this->fullName = $fullName;
        $this->username = $username;
        $this->email = $email;
        $this->experience = $experience;
        $this->profile = $profile;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->password = $password;
        $this->profilePicture = $profilePicture;
    }

        
    function getProfilePicture() {
        return $this->profilePicture;
    }

    function setProfilePicture($profilePicture): void {
        $this->profilePicture = $profilePicture;
    }

        
    function getPassword() {
        return $this->password;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

        
    function getFullName() {
        return $this->fullName;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }


    function getExperience() {
        return $this->experience;
    }

    function getProfile() {
        return $this->profile;
    }

    function getGender() {
        return $this->gender;
    }

    function getPhone() {
        return $this->phone;
    }

    function setFullName($fullName): void {
        $this->fullName = $fullName;
    }

    function setUsername($username): void {
        $this->username = $username;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setExperience($experience): void {
        $this->experience = $experience;
    }

    function setProfile($profile): void {
        $this->profile = $profile;
    }

    function setGender($gender): void {
        $this->gender = $gender;
    }

    function setPhone($phone): void {
        $this->phone = $phone;
    }

}

