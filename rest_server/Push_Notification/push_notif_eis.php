<?php

// Your FCM server key
$serverKey = 'AAAAXM9UJV0:APA91bEe1MI4Matu7v9eez1keDxTECxzgrBWLyN0zwuKuuVqFXCjzpkniK041hhVRP4_q2O-s36FmabyIqexgcguvDfVkkVgcp-Ptasruo-yUd4HsiW059CRouMJRZDJuquqGahpy5Nh';

// The device token (registration token) of the target device
$deviceToken = $_POST['device'];

// Notification payload (optional, for displaying a notification message)
$notification = [
    'title' => 'Semangat Pagi',
    'body' => $_POST["body"],
];

// Custom data payload (you can add any additional data here)
$data = [
    'key1' => 'Semangat Pagi',
    'key2' => $_POST["body"],
];

// Create the notification payload
$payload = [
    'to' => $deviceToken, // The target device's registration token
    'notification' => $notification, // Notification payload (optional)
    'data' => $data, // Custom data payload
];

// Convert the payload to JSON
$jsonPayload = json_encode($payload);

// Set up cURL to send the request to FCM
$ch = curl_init('https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: key=' . $serverKey,
]);

// Send the request and get the response
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    die('Curl error: ' . curl_error($ch));
}

// Close cURL session
curl_close($ch);

// Process the response (e.g., handle success or error)
echo 'Response: ' . $response;
