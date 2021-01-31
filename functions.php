<?php

// Config-Variablen laden
require_once("config.php");

// Formt eine Antwort, mit HTTP-Status-Code und Array -> JSON
function jsonResponse($statusCode, $data) {
    // Statuscode setzen
    http_response_code($statusCode);

    // JSON schreiben
    header('Content-type: application/json');
    echo json_encode($data);

    // Skriptausführung beenden
    exit();
}

// Gibt die URL für den Dateidownload zurück
function getFileDownloadURL($fileid) {
    return ROOTURL . "download/" . $fileid;
}

// Startet eine PHP-Session, sofern noch keine aktiv ist
function startSession() {
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
}

// Speichert Upload-Information im Verlauf in der PHP_SESSION
function pushToUploadHistory($response) {
    startSession();

    if(!isset($_SESSION['uploads'])) $_SESSION['uploads'] = [];
    $_SESSION['uploads'][] = $response;

}

// Gibt den Upload-Verlauf zurück
function getUploadHistory() {
    startSession();

    if(!isset($_SESSION['uploads'])) return null;
    return $_SESSION['uploads'];

}

// Speichert Download-Information im Verlauf in der PHP_SESSION
function pushToDownloadHistory($fileid) {
    startSession();

    if(!isset($_SESSION['downloads'])) $_SESSION['downloads'] = [];
    $_SESSION['downloads'][] = $fileid;

}

// Gibt den Download-Verlauf zurück
function getDownloadHistory() {
    startSession();

    if(!isset($_SESSION['downloads'])) return null;
    return $_SESSION['downloads'];

}


// https://stackoverflow.com/a/15875555
// Generiert eine v4 UUID
function v4($data)
{
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// Generiert eine einzigartige ID (fileid)
function uniqueID() {
    $date = new DateTime();
    return $date->format('U')."--".v4(openssl_random_pseudo_bytes(16));
}