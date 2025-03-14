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
        <a class="navbar-brand" href="#">Czatex</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="login.php">Logowanie</a>
            <a class="nav-link active" href="rejestracja.php">Rejestracja</a>
            <a class="nav-link" href="logout.php">Wyloguj</a>
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
    if(!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])){
      $email = $_POST['email'];
      $username = $_POST['username']; // zmienne z formularza
      $password = $_POST['password'];
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      
      $conn = new mysqli("localhost", "root", "", "login_system"); // baza danych
      
      function EmailTaken(){
        print("<div class='alert alert-danger' role='alert'>
            Email zajęty
            </div>");
      }

      function CheckEmail($conn, $email){
        $query = "select email from users where email='$email';";
        $result = $conn->query($query);
        if($result->num_rows > 0){
          EmailTaken();
          return true;
        }
        else{
          return false;
        }
      }
      
      function CreateAccount($conn, $email, $hashedPassword, $username){
        $stmt = $conn->prepare("INSERT INTO `users`(`first_name`, `email`, `password`) VALUES (?, ?, ?)");

        $stmt->bind_param("sss", $u, $e, $p);
        $u = $username;
        $e = $email;
        $p = $hashedPassword;

        $stmt->execute();

        $stmt->close();
        $conn->close();

        $_SESSION['loggedIn'] = true;
        $_SESSION['account'] = $email;
        $_SESSION['user'] = $username;

        header("location:dashboard.php");
      }

      if(!CheckEmail($conn, $email)){
        CreateAccount($conn, $email, $hashedPassword, $username);
      }
    }
    else{
      
    }
    ?>
    </div>
    </div>
    
</body>
</html>