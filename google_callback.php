<?php
session_start();
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->addScope('email');
$client->addScope('profile');


if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $_SESSION['nombre'] = $userInfo->name;
    $_SESSION['correo'] = $userInfo->email;
    $_SESSION['usuario'] = $userInfo->id;
    $_SESSION['rol'] = $userinfo->user;
    
    header('Location: RyParfum.php');
    exit();
} else {
    header('Location: login.php');
    exit();
}
?>
