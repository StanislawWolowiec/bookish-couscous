<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple ChatGPT App</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        input, button { padding: 10px; margin: 10px; }
        #response { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Ask ChatGPT</h2>
    <input type="text" id="userInput" placeholder="Type your question...">
    <button onclick="askChatGPT()">Ask</button>
    <p id="response"></p>

    <script>
        async function askChatGPT() {
    const userInput = document.getElementById("userInput").value;
    if (!userInput) {
        alert("Please enter a question!");
        return;
    }

    console.log("Sending prompt:", userInput);

    try {
        const res = await fetch("hugchat.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ prompt: userInput })
        });

        const data = await res.json();
        console.log("Received response:", data);

        if (data.error) {
            document.getElementById("response").textContent = "Error: " + data.error;
        } else if (Array.isArray(data)) {
            document.getElementById("response").textContent = data[0].generated_text || "No response";
        } else {
            document.getElementById("response").textContent = "Unexpected response format.";
        }
    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("response").textContent = "Error: Could not get a response.";
    }
}


    </script>
</body>
</html>
