<?php
/*
    require("../include/data.php");
    //connect
    $link = @new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    if ($link->connect_errno > 0) {
        echo $link->connect_error;
    }
    //create table Users
    $q = "CREATE TABLE Users (
        Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(30) NOT NULL,
        Email VARCHAR(50) NOT NULL,
        Password VARCHAR(256) NOT NULL,
        Activation VARCHAR(32) NOT NULL,
        ChangeActivation VARCHAR(32) NOT NULL
    )";
    $link->query($q);
    if ($link->errno > 0) {
        echo $link->error;
    }
    //create table RememberMe
    $q = "CREATE TABLE RememberMe (
        Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        UserId INT NOT NULL,
        Identifier VARCHAR(32) NOT NULL,
        Token VARCHAR(256) NOT NULL,
        ExpireTime BIGINT NOT NULL
    )";
    $link->query($q);
    if ($link->errno > 0) {
        echo $link->error;
    }
    //create table ForgotPassword
    $q = "CREATE TABLE ForgotPassword (
        Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        UserId INT NOT NULL,
        ResetKey VARCHAR(32) NOT NULL,
        ExpireTime BIGINT NOT NULL,
        Status VARCHAR(10) NOT NULL
    )";
    $link->query($q);
    if ($link->errno > 0) {
        echo $link->error;
    }
    //create table Notes
    $q = "CREATE TABLE Notes (
        Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        UserId INT NOT NULL,
        Note TEXT,
        LastModified BIGINT NOT NULL
    )";
    $link->query($q);
    if ($link->errno > 0) {
        echo $link->error;
    }
*/
    echo "You do not have permissions to run this file.";
?>
