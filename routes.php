<?php
//Map your routes there.

$router->map('GET', '/', 'pages/home.php');
$router->map('GET|POST', '/login', 'special/login.php');
$router->map('GET|POST', '/signup', 'special/signup.php');
$router->map('GET|POST', '/blog_post/create', 'pages/c_blog_post.php');
$router->map('GET', '/blog_post/[i:id]', 'pages/blog_post.php');
$router->map('GET|POST', '/profile/[i:id]', 'pages/profile.php');
$router->map('GET', '/credits', 'pages/credits.php');
$router->map('GET', '/getuserdetails', 'special/userdetails.php');
$router->map('GET', '/legal/terms', 'pages/terms.php');
$router->map('GET', '/services', 'pages/services.php');
$router->map('GET', '/legal', 'pages/legal.php');
$router->map('GET', '/oobe', 'pages/oobe.php');
$router->map('GET|POST', '/link', 'pages/link.php');
$router->map('GET', '/news', 'pages/news.php');
$router->map('GET', '/admin', 'pages/admin.php');
$router->map('GET', '/admin/feedbacks', 'pages/feedbacks.php');
$router->map('GET|POST', '/feedback', 'pages/feedback.php');
$router->map('GET|POST', '/admin/feedback_mg', 'pages/feedback_mg.php');
$router->map('GET|POST', '/admin/ban', 'pages/ban.php');
$router->map('GET|POST', '/edit-profile', 'pages/edit-profile.php');
$router->map('GET', '/logout', 'special/logout.php');