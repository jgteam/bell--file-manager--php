<?php

// Gibt den Verlauf zurück

require_once("./../functions.php");

$history = getUploadHistory();

if($history === null) {
    jsonResponse(404, null);
} else {
    jsonResponse(200, $history);
}
