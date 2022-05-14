<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/app.php";
$dbClass = new Database;
$conn =  $dbClass->connect();
$userClass = new User;
$appClass = new App;
header("Content-Type: application/json");
if(!isset($_GET['token'])){
    echo '{"success":0, "errorMsg":"TOKEN_NOT_RECEIVED"}';
    exit;
}
$token = $appClass->getTokenFromToken($conn, $_GET['token']);
if(!$token){
    echo '{"success":0, "errorMsg":"TOKEN_NOT_VALID"}';
    exit;
}
$appClass->updateUsedCount($conn, $_GET['token']);
$user = $userClass->getUserFromID($conn, $token['user_id']);
$array = array("id" => $user['id'], "username" => $user['username'], "email" => $user['email']);
$encodedarray = json_encode($array, JSON_PRETTY_PRINT);
echo $encodedarray;