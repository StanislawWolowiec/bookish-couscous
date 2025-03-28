<?php

function EmailTaken(){
    print("<div class='alert alert-danger m-2' role='alert'>Email zajęty</div>");
  }

  function InvalidEmain(){
    print("<div class='alert alert-danger m-2' role='alert'>Email nieprawidłowy</div>");
  }

  function CheckEmail($pdo, $email){
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if($stmt->rowCount() > 0){
      EmailTaken();
      return false;
    }
  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      InvalidEmain();
      return false;
    } 
    return true;
  
  }

  function IncorrectPassword($passRules){
    for($i = 0; $i < count($passRules); $i++){
      if($passRules[$i] == "short"){
        print("<div class='alert alert-danger m-2' role='alert'>Hasło musi mieć co najmniej 8 znaków</div>");
      }
      if($passRules[$i] == "upper"){
        print("<div class='alert alert-danger m-2' role='alert'>Hasło musi mieć duże litery</div>");
      }
      if($passRules[$i] == "lower"){
        print("<div class='alert alert-danger m-2' role='alert'>Hasło musi mieć małe litery</div>");
      }
    }
  }

  function CheckPassword(){
    $pass = $_POST['password'];
    $isGood = True;
    $passRules = array();

    if(strlen($pass) < 8){
      $isGood = False;
      $passRules[] = "short";
    }

    $upperCase = preg_match('/[A-Z]/', $pass); 
    if($upperCase == False){
      $isGood = False;
      $passRules[] = "upper";
    }
    $lowerCase = preg_match('/[a-z]/', $pass);
    if($lowerCase == False){
      $isGood = False;
      $passRules[] = "lower";
    }

    if($isGood == False){
      IncorrectPassword($passRules);
      return false;
    }
      return true;
  }
  
  function CreateAccount($pdo, $email, $hashedPassword, $username){
    $stmt = $pdo->prepare("INSERT INTO `users`(`first_name`, `email`, `password`) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    $_SESSION['loggedIn'] = true;
    $_SESSION['account'] = $email;
    $_SESSION['user'] = $username;

    header("location:dashboard.php");
  }

?>