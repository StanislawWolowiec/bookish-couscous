<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
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
            <a class="nav-link" aria-current="page" href="login.php">Logowanie</a>
            <a class="nav-link active" href="rejestracja.php">Rejestracja</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container">
    <div class="container w-25">
        <h1 class="mb-5">Login</h1>
        <form method="post">
            <div class="mb-3">
              <label for="InputEmail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="InputEmail" name="email">
            </div>
            <div class="mb-3">
                <label for="InputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="InputPassword" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    
    
    <?php
    include("niezalogowany.php");

    try {
      $pdo = new PDO("mysql:host=localhost;dbname=login_system", "root", "", [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
    } catch (PDOException $e) {
      die("Database connection failed: " . $e->getMessage());
    }

    function NoEmail() {
      print("<div class='alert alert-danger' role='alert'>Nie ma konta z takim emailem</div>");
    }

    function BadPassword() {
      print("<div class='alert alert-danger' role='alert'>Złe hasło</div>");
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

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
      CheckLoginData($pdo, $_POST['email'], $_POST['password']);
    }
    ?>
    </div>
    </div>
    
</body>
</html>