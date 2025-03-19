<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <?php
             if($_SESSION['loggedIn'] == True){
              print('<a class="nav-link active" href="dashboard.php">Dashboard</a>');
              print('<a class="nav-link active" href="Hugchat.php">Chat</a>');
              print('<a class="nav-link active" href="logout.php">Wyloguj</a>');
             }
              else{
                print('<a class="nav-link active" aria-current="page" href="login.php">Logowanie</a>');
                print('<a class="nav-link active" href="rejestracja.php">Rejestracja</a>');
              }
            ?>
          </div>
        </div>
      </div>
    </nav>

    <div class="container d-flex justify-content-center">
      <h1>Super Strona</h1>
    </div>
    <div class="container d-flex justify-content-center mt-5">
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique amet sint quos. Consequuntur quia consequatur quibusdam dolor iure, nulla optio voluptas minus accusantium ad a deleniti qui saepe repellat ipsam quod at quasi earum, facilis voluptates. Delectus, veniam repellendus. Quia, libero voluptas ex excepturi officia neque tempora ad, numquam rem modi explicabo illo iste totam? Accusantium alias soluta ex a!</p>
    </div>
</body>
</html>