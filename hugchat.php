<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php
    session_start();
    include("PHPModules/CheckIfLoggedIn.php");
    ?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Strona</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
          <a class="nav-link active" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="hugchat.php">Chat</a>
            <a class="nav-link active" href="PHPModules/logout.php">Wyloguj</a>
          </div>
        </div>
      </div>
    </nav>
    
    <div class="container text-center">
        <h1>Ask Chat</h1>
    </div>

    <div class="container" id="messages"></div>
    
    <div class="container d-flex flex-column justify-content-center align-items-center mt-5 w-50">
        <input class="form-control w-50" type="text" id="userInput" placeholder="Type your question...">
        <button class="btn btn-primary mt-2" onclick="askChatGPT()">Ask</button>
    </div>
    
    <script src="JavaScript/chatscript.js"></script>
</body>
</html>
