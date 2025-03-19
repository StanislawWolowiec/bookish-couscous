<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <?php
    session_start();
    //Sesja  ['loggedIn'], ['user'], ['account']
    ?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Strona</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="login.php">Logowanie</a>
            <a class="nav-link" href="rejestracja.php">Rejestracja</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container">
    <div class="container w-25">
        <h1 class="mb-5">Register</h1>
        <form method="post">
            <div class="mb-3">
              <label for="InputEmail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="InputEmail" name="email">
            </div>
            <div class="mb-3">
              <label for="InputUsername class="form-label">First Name</label>
              <input type="text" class="form-control" id="InputUsername" name="username">
            </div>
            <div class="mb-3">
                <label for="InputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="InputPassword" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    
    
    <?php
    
      try {
        $pdo = new PDO("mysql:host=localhost;dbname=login_system", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
      } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
      }
      
      function EmailTaken(){
        print("<div class='alert alert-danger' role='alert'>Email zajęty</div>");
      }

      function CheckEmail($pdo, $email){
        $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0){
          EmailTaken();
          return true;
        }
        else{
          return false;
        }
      }

      function IncorrectPassword($passRules){
        for($i = 0; $i < count($passRules); $i++){
          if($passRules[$i] == "short"){
            print("<div class='alert alert-danger' role='alert'>Hasło musi mieć co najmniej 8 znaków</div>");
          }
          if($passRules[$i] == "upper"){
            print("<div class='alert alert-danger' role='alert'>Hasło musi mieć duże litery</div>");
          }
          if($passRules[$i] == "lower"){
            print("<div class='alert alert-danger' role='alert'>Hasło musi mieć małe litery</div>");
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

      if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        if(!CheckEmail($pdo, $_POST['email'])){
          if(CheckPassword()){
            CreateAccount($pdo, $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['username']);
          }
        }
      }
    
    ?>
    </div>
    </div>
    
</body>
</html>