<?php
require_once "./utils/database.php";
$dbClass = new Database;
$dbClass->init_session();
$conn = $dbClass->connect();
$query = $conn->prepare("DELETE FROM `tokens` WHERE `token`=:token");
$query->execute([
    "token" => $_SESSION['token']
]);
session_unset();
header("Location: /");