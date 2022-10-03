<?php

$dbConn = new mysqli('localhost', 'root', '', 'performancereview018');
if ($dbConn->connect_error) {
 die('Connection error (' . $dbConn->connect_errno . ')'
 . $dbConn->connect_error);
}