<?php

// require_once __DIR__ . '/../vendor/autoload.php';
// use \Firebase\JWT\JWT;

// // Path to your service account file
// $serviceAccountPath = __DIR__ . '/mobile-ess-bbt-3b1a0d5542f7.json'; // Jika file ada di direktori yang sama
// $tokenUri = 'https://oauth2.googleapis.com/token';
// $fcmUrl = 'https://fcm.googleapis.com/v1/projects/mobile-ess-bbt/messages:send';

// // Step 1: Get OAuth 2.0 Token (as described earlier)
// $serviceAccountData = json_decode(file_get_contents($serviceAccountPath), true);

// // Generate JWT assertion
// $assertion = [
//     'iss' => $serviceAccountData['client_email'],
//     'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
//     'aud' => $tokenUri,
//     'iat' => time(),
//     'exp' => time() + 3600,
// ];

// $jwt = JWT::encode($assertion, $serviceAccountData['private_key'], 'RS256');

// // Exchange JWT for OAuth 2.0 token
// $response = json_decode(file_get_contents($tokenUri, false, stream_context_create([
//     'http' => [
//         'method' => 'POST',
//         'header' => 'Content-Type: application/x-www-form-urlencoded',
//         'content' => http_build_query([
//             'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
//             'assertion' => $jwt,
//         ]),
//     ],
// ])), true);

// $accessToken = $response['access_token'];

// // Step 2: Send FCM notification
// $deviceToken = $_POST['device'];

// $notification = [
//     'title' => $_POST['title'],
//     'body' => $_POST['body'],
// ];

// $data = [
//     'key1' => $_POST['title'],
//     'key2' => $_POST['body'],
// ];

// $payload = [
//     'message' => [
//         'token' => $deviceToken, 
//         'notification' => $notification,
//         'data' => $data,
//     ],
// ];

// $options = [
//     'http' => [
//         'header' => "Authorization: Bearer $accessToken\r\nContent-Type: application/json\r\n",
//         'method' => 'POST',
//         'content' => json_encode($payload),
//     ],
// ];

// $context = stream_context_create($options);
// $result = file_get_contents($fcmUrl, false, $context);

// echo $result;

//================================================================ VERSI WINDOWS ADA DIATAS ===================================================================

//================================================================ VERSI LINUX ADA DIBAWAH ===================================================================


// require_once __DIR__ . '/../vendor/autoload.php';
// use \Firebase\JWT\JWT;

// // Path to your service account file
// $serviceAccountPath = __DIR__ . '/mobile-ess-bbt-firebase-adminsdk-8dzrj-4be7e95384.json'; // Jika file ada di direktori yang sama
// $tokenUri = 'https://oauth2.googleapis.com/token';
// $fcmUrl = 'https://fcm.googleapis.com/v1/projects/mobile-ess-bbt/messages:send';

// // Step 1: Get OAuth 2.0 Token (as described earlier)
// $serviceAccountData = json_decode(file_get_contents($serviceAccountPath), true);
// // var_dump($serviceAccountData['private_key']);
// // exit;

// if (!$serviceAccountData) {
//     echo "Error parsing JSON: " . json_last_error_msg();
//     exit;
// }

// // Generate JWT assertion
// $assertion = [
//     'iss' => $serviceAccountData['client_email'],
//     'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
//     'aud' => $tokenUri,
//     'iat' => time(),
//     'exp' => time() + 3600,
// ];

// $jwt = JWT::encode($assertion, $serviceAccountData['private_key'], 'RS256');
// // $jwt = JWT::encode($assertion, str_replace(["\n", "\r"], '', $serviceAccountData['private_key']), 'RS256');
// // echo "JWT: " . $jwt;
// // exit;

// // Exchange JWT for OAuth 2.0 token
// $response = file_get_contents($tokenUri, false, stream_context_create([
//     'http' => [
//         'method' => 'POST',
//         'header' => 'Content-Type: application/x-www-form-urlencoded',
//         'content' => http_build_query([
//             'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
//             'assertion' => $jwt,
//         ]),
//     ],
// ]));
// // var_dump($response);
// // exit;
// var_dump(file_get_contents('https://www.google.com'));

// // Tambahkan pengecekan error setelah request token
// if ($response === false) {
//     echo "Error fetching OAuth token : " . error_get_last()['message'];
//     exit;
// }

// $responseData = json_decode($response, true);
// $accessToken = $responseData['access_token'] ?? null;

// // Cek apakah access token berhasil didapatkan
// if (!$accessToken) {
//     echo "Failed to retrieve access token. Response: " . $response;
//     exit;
// }

// // Step 2: Send FCM notification
// $deviceToken = $_POST['device'];

// $notification = [
//     'title' => $_POST['title'],
//     'body' => $_POST['body'],
// ];

// $data = [
//     'key1' => $_POST['title'],
//     'key2' => $_POST['body'],
// ];

// $payload = [
//     'message' => [
//         'token' => $deviceToken, 
//         'notification' => $notification,
//         'data' => $data,
//     ],
// ];

// $options = [
//     'http' => [
//         'header' => "Authorization: Bearer $accessToken\r\nContent-Type: application/json\r\n",
//         'method' => 'POST',
//         'content' => json_encode($payload),
//     ],
// ];

// $context = stream_context_create($options);
// $result = file_get_contents($fcmUrl, false, $context);

// // Tambahkan pengecekan error setelah mengirim notifikasi
// if ($result === false) {
//     echo "Error sending FCM notification: " . error_get_last()['message'];
//     exit;
// }

// echo $result;


require_once __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;

// Path ke service account JSON
$serviceAccountPath = __DIR__ . '/mobile-ess-bbt-17cdf98c714b.json';
$tokenUri = 'https://oauth2.googleapis.com/token';
$fcmUrl = 'https://fcm.googleapis.com/v1/projects/mobile-ess-bbt/messages:send';

// Step 1: Ambil data dari service account JSON
$serviceAccountData = json_decode(file_get_contents($serviceAccountPath), true);

if (!$serviceAccountData) {
    die("Error parsing JSON: " . json_last_error_msg());
}

// Generate JWT
$assertion = [
    'iss'   => $serviceAccountData['client_email'],
    'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    'aud'   => $tokenUri,
    'iat'   => time(),
    'exp'   => time() + 3600,
];

$jwt = JWT::encode($assertion, $serviceAccountData['private_key'], 'RS256');
// echo "Generated JWT: " . $jwt; 
// exit;

// Exchange JWT dengan OAuth 2.0 token pakai cURL
$ch = curl_init($tokenUri);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion' => $jwt,
]));

$response = curl_exec($ch);
if ($response === false) {
    die("Error fetching OAuth token: " . curl_error($ch));
}
curl_close($ch);

//responsedata
$responseData = json_decode($response, true);
$accessToken = $responseData['access_token'] ?? null;

if (!$accessToken) {
    die("Failed to retrieve access token. Response: " . $response);
}

// Step 2: Kirim FCM Notifikasi pakai cURL
$deviceToken = $_POST['device'];
$notification = [
    'title' => $_POST['title'],
    'body'  => $_POST['body'],
];

$data = [
    'key1' => $_POST['title'],
    'key2' => $_POST['body'],
];

$payload = [
    'message' => [
        'token'        => $deviceToken,
        'notification' => $notification,
        'data'         => $data,
    ],
];

$ch = curl_init($fcmUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$result = curl_exec($ch);
if ($result === false) {
    die("Error sending FCM notification: " . curl_error($ch));
}
curl_close($ch);

echo $result;



