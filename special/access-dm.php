<?php
require_once "./utils/database.php";
require_once "./database/dm.php";
require_once "./database/user.php";
$dbClass = new Database;
$dmClass = new Dm;
$userClass = new User;
$dbClass->init_session();
$conn = $dbClass->connect();
if(!isset($_SESSION['token'])){
    header("Location: /login");
}
if(!isset($_GET['source']) && !isset($_GET['target'])){
    header("Location: /");
}
$cuser = $userClass->getUserFromToken($conn, $_SESSION['token']);
$chk = $userClass->getUserFromID($conn, $_GET['source']);
if(!$chk){
    header("Location: /");
    exit;
}else if($chk['id']!==$cuser['id']){
    header("Location: /");
    exit;
}
$chk = $userClass->getUserFromID($conn, $_GET['target']);
if(!$chk){
    header("Location: /");
    exit;
}else if($chk['id']==$cuser['id']){
    header("Location: /");
    exit;
}
$chk = $dmClass->getConversationFromSourceAndTarget($conn, $_GET['source'], $_GET['target']);
if(!$chk){
    $dmClass->createConversation($conn, $_GET['source'], $_GET['target']);
}
$dm = $dmClass->getConversationFromSourceAndTarget($conn, $_GET['source'], $_GET['target']);
header("Location: /conversation/".$dm['cid']);