<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Cargar la librería de Google API Client
require_once 'vendor/autoload.php';

// Configurar las credenciales
$client = new Google_Client();
// Cargar el archivo client_secrets.json
$client->setAuthConfig('client_secrets.json');
$client->setRedirectUri('http://localhost/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE_READONLY);

// Si la autenticación es exitosa
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();

    header('Location: http://localhost');
    exit();
}

// Si no se puede obtener el código, redirigir a la página principal
header('Location: http://localhost');
exit();
