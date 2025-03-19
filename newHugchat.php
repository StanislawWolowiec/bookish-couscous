<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple ChatGPT App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php
    session_start();
    if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
        header("location:niezalogowany.php");
        exit();
    }
    ?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Czatex</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="login.php">Logowanie</a>
            <a class="nav-link" href="rejestracja.php">Rejestracja</a>
            <a class="nav-link active" href="logout.php">Wyloguj</a>
          </div>
        </div>
      </div>
    </nav>
    
    <div class="container text-center mt-4">
        <h1>Ask Chat</h1>
    </div>

    <div class="container" id="messages"></div>
    
    <div class="container d-flex flex-column justify-content-center align-items-center mt-5 w-50">
        <input class="form-control w-50" type="text" id="userInput" placeholder="Type your question...">
        <button class="btn btn-primary mt-2" onclick="askChatGPT()">Ask</button>
    </div>
    
    <script>
    async function askChatGPT() {
        const userInput = document.getElementById("userInput").value;
        if (!userInput) {
            alert("Please enter a question!");
            return;
        }
        
        // Create user message div
        const userMessage = document.createElement("div");
        userMessage.className = "alert alert-secondary w-50 ms-auto mt-2";
        userMessage.textContent = userInput;
        document.getElementById("messages").appendChild(userMessage);

        // Clear input field
        document.getElementById("userInput").value = "";

        try {
            const res = await fetch("hugchat.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ prompt: userInput })
            });

            const data = await res.json();
            console.log("Received response:", data);

            // Create AI response div
            const aiResponse = document.createElement("div");
            aiResponse.className = "alert alert-primary w-50 me-auto mt-2";
            aiResponse.textContent = data.error ? "Error: " + data.error : data[0]?.generated_text || "No response";
            document.getElementById("messages").appendChild(aiResponse);
        } catch (error) {
            console.error("Fetch error:", error);
            const errorMessage = document.createElement("div");
            errorMessage.className = "alert alert-danger w-50 me-auto mt-2";
            errorMessage.textContent = "Error: Could not get a response.";
            document.getElementById("messages").appendChild(errorMessage);
        }
    }
    </script>
</body>
</html>
