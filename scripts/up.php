<?php

$file = (isset($_FILES['file'])) ? $_FILES['file'] : null;

require_once("./../functions.php");

if($file === null) {
    jsonResponse(400, [
        'status' => false,
        'message' => 'No file uploaded'
    ]);
}

$fileid = uniqueID();

// https://www.php.net/manual/de/features.file-upload.post-method.php

$uploaddir = dirname(dirname(__FILE__)) . '/filestorage/';
$uploadfile = $uploaddir . $fileid;
$filename = basename($file['name']);

move_uploaded_file($file['tmp_name'], $uploadfile);

$sql = "INSERT INTO files_php (id, filename) VALUES ('" . mysqli_real_escape_string($con, $fileid) . "', '" . mysqli_real_escape_string($con, $filename) . "')";
mysqli_query($con, $sql);

jsonResponse(200, [
    'status' => true,
    'filename' => $filename,
    'download' => getFileDownloadURL($fileid)
]);
