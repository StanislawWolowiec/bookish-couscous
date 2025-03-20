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
    if($_SESSION['loggedIn'] == False){
      $_SESSION['loggedOut'] = True;
      header("location:login.php");
    }
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
            <a class="nav-link" href="Hugchat.php">Chat</a>
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

        // Clear input field
        document.getElementById("userInput").value = "";

        const messages = document.getElementById("messages"); // messages div

        // create user message
        const messagediv = document.createElement("div");
        messagediv.className = "container d-flex flex-row-reverse align-items-center justify-content-center";
        messages.appendChild(messagediv);
        
        const userimage = document.createElement("img");
        userimage.style.width = "100px";
        userimage.style.height = "100px";
        userimage.className = "border";
        userimage.src = "images/ziutek.jpg";
        
        const userMessage = document.createElement("div");
        userMessage.className = "alert alert-secondary w-50 ms-auto mt-2";
        userMessage.textContent = userInput;
        messagediv.appendChild(userimage);
        messagediv.appendChild(userMessage);

        //-------------------------------------------------

        // create ai response
        const responsediv = document.createElement("div");
        responsediv.className = "container d-flex flex-row align-items-center justify-content-center";
        messages.appendChild(responsediv);

        const aiImage = document.createElement("img");
        aiImage.style.width = "100px";
        aiImage.style.height = "100px";
        aiImage.className = "border";
        aiImage.src = "images/chat.jpg";
        
        const aiResponse = document.createElement("div");
        aiResponse.className = "alert alert-primary w-50 me-auto mt-2";
        aiResponse.textContent = "...";
        responsediv.appendChild(aiImage);
        responsediv.appendChild(aiResponse);

        //------------------------------------------

        try {
            const res = await fetch("askhugchat.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ prompt: userInput })
            });

            const data = await res.json();
            console.log("Received response:", data);

            
            aiResponse.className = "alert alert-primary w-50 me-auto mt-2";
            aiResponse.textContent = data.error ? "Error: " + data.error : data[0]?.generated_text || "No response";
        } catch (error) {
            console.error("Fetch error:", error);
            aiResponse.className = "alert alert-danger w-50 me-auto mt-2";
            aiResponse.textContent = "Error: Could not get a response.";
        }
    }
    </script>
</body>
</html>
