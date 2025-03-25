<?php

if($_SESSION['loggedIn'] == False){
  $_SESSION['loggedOut'] = True;
  header("location:login.php");
}

?>