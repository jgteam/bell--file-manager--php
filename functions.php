<?php

require_once("config.php");

function jsonResponse($statusCode, $data) {
    http_response_code($statusCode);
    header('Content-type: application/json');
    echo json_encode($data);
    exit();
}

function getFileDownloadURL($fileid) {
    return ROOTURL . "download/" . $fileid;
}

// https://stackoverflow.com/a/15875555
function v4($data)
{
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function uniqueID() {
    $date = new DateTime();
    return $date->format('U')."--".v4(openssl_random_pseudo_bytes(16));
}