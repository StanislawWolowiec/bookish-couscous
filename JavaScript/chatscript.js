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
        const res = await fetch("PHPModules/askhugchat.php", {
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