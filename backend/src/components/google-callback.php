<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('VOTRE_CLIENT_ID');
$client->setClientSecret('VOTRE_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/SpendEase/backend/src/components/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    $_SESSION['user'] = $userInfo;

    header('Location: /SpendEase/frontend/src/index.html');
    exit();
} else {
    header('Location: /SpendEase/frontend/src/index.html');
    exit();
}
