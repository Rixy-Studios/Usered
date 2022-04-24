<?php
//Usered entrypoint!!!
require_once "utils/server.php";
require_once "utils/altorouter.php";
$router = new AltoRouter;
require_once "routes.php";
$server = new Server;
$server->redirectToHttps();
$server->start($router);