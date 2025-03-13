<?php
session_start();
$_SESSION['zalogowany'] = False;
$_SESSION['user'] = null;

header("location:login.php")
?>