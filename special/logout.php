<?php
require_once "./utils/database.php";
$dbClass = new Database;
$dbClass->init_session();
session_unset();
header("Location: /");