<?php
class Server{
    public function redirectToHttps(){
        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
            $location = 'https://' . $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $location);
            exit;
        }
    }
    public function start($router){
        $match = $router->match(urldecode($_SERVER['REQUEST_URI']));
        if ($match) {
            foreach ($match['params'] as &$param) {
                ${key($match['params'])} = $param;
            }
            require_once $match['target'];
        } else {
            http_response_code(404);
            exit(require 'pages/404.php');
        }
    }
}