<?php
/*

Usered - The way USERS want it to be.

A RixyStudios creation, copyright assets 2022.

Authors: Rixy, Terminal, Bruhdude.
*/
require_once "utils/server.php";
require_once "utils/altorouter.php";
$router = new AltoRouter;
require_once "routes.php";
$server = new Server;
$server->redirectToHttps();
$server->start($router);