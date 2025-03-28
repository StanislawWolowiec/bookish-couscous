<?php

function NoEmail() {
    print("<div class='alert alert-danger m-2' role='alert'>Nie ma konta z takim emailem</div>");
  }

  function BadPassword() {
    print("<div class='alert alert-danger m-2' role='alert'>Złe hasło</div>");
  }

  function IsGoodPassword($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $table = $stmt->fetch();
    $hashedPassword = $table['password'];
    
    return password_verify($password, $hashedPassword);
  }

  function LogInToSite($pdo, $email) {
    $_SESSION['loggedIn'] = true;
    $_SESSION['account'] = $email;
    
    $stmt = $pdo->prepare("SELECT first_name FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $table = $stmt->fetch();
    $_SESSION['user'] = $table['first_name'];
    
    header("Location: dashboard.php");
    exit();
  }

  function InvalidEmail(){
    print("<div class='alert alert-danger m-2' role='alert'>Email nieprawidłowy</div>");
  }

  function CheckLoginData($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        if (IsGoodPassword($pdo, $email, $password)) {
            LogInToSite($pdo, $email);
        } else {
            BadPassword();
        }
    } else {
        NoEmail();
    }
  }

?>