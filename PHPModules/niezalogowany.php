<?php
if(!isset($_SESSION['loggedOut'])){
    $_SESSION['loggedOut'] = False;
  }
if($_SESSION['loggedOut']){
    print("<div class='alert alert-danger m-2' role='alert'>Powrót do logowania, <br> nie jesteś zalogowany</div>");
    $_SESSION['loggedOut'] = False;
}
?>