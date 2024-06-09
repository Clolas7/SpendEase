<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('350239869325-gjhc0ajkrakq1ol1vbo7t6ov2mjhtdlh.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://spendeasesafe.com/backend/src/components/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $_SESSION['user'] = $userInfo;

    header('Location: https://spendeasesafe.com/frontend/src/index.html');
    exit();
} else {
    header('Location: https://spendeasesafe.com/frontend/src/index.html');
    exit();
}
