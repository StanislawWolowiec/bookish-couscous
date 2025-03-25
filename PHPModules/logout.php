<?php
session_start();
//Sesja  ['loggedIn'], ['user'], ['account']
$_SESSION['loggedIn'] = False;
$_SESSION['user'] = null;

header("location:../login.php");
?>