<?php
// Check if the city parameter is set
if (!isset($_GET['city'])) {
    echo json_encode(["error" => "City parameter not found."]);
    exit;
}

$city = urlencode($_GET['city']);
$apiKey = '7a02710e199ef112ec80ddc590438dec'; 
$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric"; // Using metric for Celsius

$response = file_get_contents($url);
if ($response === FALSE) {
    echo json_encode(["error" => "Unable to fetch weather data."]);
    exit;
}

$data = json_decode($response, true);
if ($data['cod'] !== 200) {
    echo json_encode(["error" => $data['message']]);
    exit;
}

// Return the required weather data
echo json_encode([
    "name" => $data['name'],
    "main" => [
        "temp" => $data['main']['temp'],
        "humidity" => $data['main']['humidity'],
        "pressure" => $data['main']['pressure']
    ],
    "weather" => $data['weather'],
    "wind" => [
        "speed" => $data['wind']['speed']
    ]
]);
?>

