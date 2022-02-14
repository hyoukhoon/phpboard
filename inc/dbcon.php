<?php

$hostname="localhost";
$dbuserid="testman";
$dbpasswd="1111";
$dbname="testdb";

$mysqli = new mysqli($hostname, $dbuserid, $dbpasswd, $dbname);
if ($mysqli->connect_errno) {
    die('Connect Error: '.$mysqli->connect_error);
}

?>