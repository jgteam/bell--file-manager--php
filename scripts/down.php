<?php

$fileid = (isset($_GET['fileid'])) ? $_GET['fileid'] : null;

require_once("./../functions.php");

if($fileid === null) {
    jsonResponse(400, [
        'status' => false,
        'message' => 'Fileid not defined'
    ]);
}

if($fileid == "") {
    jsonResponse(400, [
        'status' => false,
        'message' => 'Fileid empty'
    ]);
}

$sql = "SELECT * FROM files_php WHERE id = '" . mysqli_real_escape_string($con, $fileid) . "'";
$res = mysqli_query($con, $sql);

if (mysqli_num_rows($res) > 0) {

    $filename = null;

    while($row = mysqli_fetch_assoc($res)) {
        $filename = $row["filename"];
    }

    $file = dirname(dirname(__FILE__)) . '/filestorage/'.$fileid;

    if(!file_exists($file)){ // file does not exist
        jsonResponse(404, [
            'status' => false,
            'message' => 'File not found'
        ]);
    } else {
        http_response_code(200);
        header("Content-Type: plain/text");
        header("Content-Disposition: attachment; filename=$filename");

        // https://stackoverflow.com/a/12094230
        readfile($file);
    }

} else {
    jsonResponse(404, [
        'status' => false,
        'message' => 'File not found'
    ]);
}