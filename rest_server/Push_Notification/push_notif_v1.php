<?php

require_once __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;

// Path to your service account file
$serviceAccountPath = __DIR__ . '/mobile-ess-bbt-3b1a0d5542f7.json'; // Jika file ada di direktori yang sama
$tokenUri = 'https://oauth2.googleapis.com/token';
$fcmUrl = 'https://fcm.googleapis.com/v1/projects/mobile-ess-bbt/messages:send';

// Step 1: Get OAuth 2.0 Token (as described earlier)
$serviceAccountData = json_decode(file_get_contents($serviceAccountPath), true);

// Generate JWT assertion
$assertion = [
    'iss' => $serviceAccountData['client_email'],
    'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    'aud' => $tokenUri,
    'iat' => time(),
    'exp' => time() + 3600,
];

$jwt = JWT::encode($assertion, $serviceAccountData['private_key'], 'RS256');

// Exchange JWT for OAuth 2.0 token
$response = json_decode(file_get_contents($tokenUri, false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]),
    ],
])), true);

$accessToken = $response['access_token'];

// Step 2: Send FCM notification
$deviceToken = $_POST['device'];

$notification = [
    'title' => $_POST['title'],
    'body' => $_POST['body'],
];

$data = [
    'key1' => $_POST['title'],
    'key2' => $_POST['body'],
];

$payload = [
    'message' => [
        'token' => $deviceToken, 
        'notification' => $notification,
        'data' => $data,
    ],
];

$options = [
    'http' => [
        'header' => "Authorization: Bearer $accessToken\r\nContent-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($payload),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($fcmUrl, false, $context);

echo $result;
