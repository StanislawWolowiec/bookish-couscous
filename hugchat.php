<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$huggingface_api_key = ""; // Replace with your API key
$api_url = "https://api-inference.huggingface.co/models/Qwen/QwQ-32B";

// Read input
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Check if "prompt" exists in the request
if (!isset($data["prompt"]) || empty($data["prompt"])) {
    echo json_encode(["error" => "Empty prompt"]);
    exit;
}

$prompt = $data["prompt"]; // ✅ Fixed the missing prompt issue

// Prepare API request
$request_data = ["inputs" => $prompt];

$headers = [
    "Authorization: Bearer " . $huggingface_api_key,
    "Content-Type: application/json"
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));

$response = curl_exec($ch);
curl_close($ch);

// Send back the response
echo $response;
?>
