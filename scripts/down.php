<?php

// DOWNLOAD

// Funktionen und MySQL-Connection laden
require_once("./../functions.php");

$fileid = (isset($_GET['fileid'])) ? $_GET['fileid'] : null;

if($fileid === null) {
    // fileid-Parameter ist nicht definiert/übergeben worden

    // Error-Antwort erstellen
    jsonResponse(400, [
        'status' => false,
        'message' => 'Fileid not defined'
    ]);
}

if($fileid == "") {
    // fileid-Parameter ist leer

    // Error-Antwort erstellen
    jsonResponse(400, [
        'status' => false,
        'message' => 'Fileid empty'
    ]);
}

// SQL-QUERY: Sucht die Daten zur fileid raus
$sql = "SELECT * FROM files_php WHERE id = '" . mysqli_real_escape_string($con, $fileid) . "'";
$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) > 0) {
    // SQL-QUERY hat ein Ergebnis geliefert

    $filename = null;

    // filename aus der Datenbank in eine Variable schreiben
    while($row = mysqli_fetch_assoc($res)) {
        $filename = $row["filename"];
    }

    // Absoluter Dateipfad
    $file = dirname(dirname(__FILE__)) . '/filestorage/'.$fileid;

    if(!file_exists($file)){
        // Datei existiert nicht

        // Error-Antwort erstellen
        jsonResponse(404, [
            'status' => false,
            'message' => 'File not found'
        ]);

    } else {
        // Datei existiert

        // In der History speichern
        pushToDownloadHistory($fileid);

        // Dateidownload-Antwort erstellen
        http_response_code(200);
        header("Content-Type: plain/text");
        header("Content-Disposition: attachment; filename=$filename");

        // https://stackoverflow.com/a/12094230
        // Datei auslesen
        readfile($file);
    }

} else {
    // SQL-QUERY hatte kein Treffer in der Datenbank

    // Error-Antwort erstellen
    jsonResponse(404, [
        'status' => false,
        'message' => 'File not found'
    ]);
}