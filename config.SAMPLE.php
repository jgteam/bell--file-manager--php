<?php

/*
--
-- Tabellenstruktur für Tabelle `files_php`
--
CREATE TABLE `files_php` ( `id` VARCHAR(64) NOT NULL , `filename` VARCHAR(512) NOT NULL , `uploadtimestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/

define("HOST", "localhost");
define("USER", "user");
define("PASSWORD", "password");
define("DATABASE", "dbname");

// eg: "https://example.com/"
define("ROOTURL", "http:://localhost/filemgr/");

$con = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($con->connect_errno)
    die("Die Verbindung zu dem Datenbankserver konnte nicht hergestellt werden.");
