<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$api_key = "";
$api_url = "https://api.openai.com/v1/chat/completions";

// Read input
$input = file_get_contents("php://input");
$data = json_decode($input, true);
$prompt = $data["prompt"] ?? "";

// Log received JSON
file_put_contents("log.txt", "Received JSON: " . print_r($data, true), FILE_APPEND);

// If prompt is empty, return error
if (empty($prompt)) {
    echo json_encode(["error" => "Empty prompt"]);
    exit;
}

// Prepare API request
$request_data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [["role" => "user", "content" => $prompt]]
];

// Make API request using cURL
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $api_key
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Log API response
file_put_contents("log.txt", "\nOpenAI API Response: " . $response . "\n", FILE_APPEND);

if ($response === FALSE) {
    echo json_encode(["error" => "API request failed"]);
    exit;
}

// Decode API response
$response_data = json_decode($response, true);

// Check if OpenAI returned a valid response
if (!isset($response_data["choices"][0]["message"]["content"])) {
    echo json_encode(["error" => "Invalid API response", "http_code" => $http_code, "response" => $response_data]);
    exit;
}

// Return the response to the frontend
echo json_encode(["response" => $response_data["choices"][0]["message"]["content"]]);
?>
