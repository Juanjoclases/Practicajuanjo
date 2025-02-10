<?php

session_start();

// Cargar la librería de Google API Client
require_once 'vendor/autoload.php';

// Configurar las credenciales desde el archivo client_secrets.json
$client = new Google_Client();
$client->setAuthConfig('client_secrets.json');
$client->setRedirectUri('http://localhost/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE_READONLY);

// Si el usuario ya está autenticado
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);

    // Obtener los archivos de Google Drive
    $driveService = new Google_Service_Drive($client);
    $files = $driveService->files->listFiles();

    echo '<h1>Archivos en Google Drive</h1>';
    echo '<ul>';

    foreach ($files as $file) {
        echo '<li>' . $file->getName() . '</li>';
    }

    echo '</ul>';

} else {
    // Si el usuario no está autenticado, redirigirlo a la página de autenticación
    $authUrl = $client->createAuthUrl();
    echo '<a href="' . $authUrl . '">Iniciar sesión con Google</a>';
}
