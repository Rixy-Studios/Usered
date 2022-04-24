<?php
/* Ugliest file ever.

Needs entire rewrite to the new way to do this shit.

*/
require_once "./utils/database.php";
require_once "./utils/utils.php";
$dbClass = new Database;
$dbClass->init_session();
$conn = $dbClass->connect();
if(isset($_SESSION['token'])){
    header("Location: /");
}
if(!isset($_GET['userToken'])){
    exit("No userToken found; aborting.");
}
$api = file_get_contents('http://pi.rixynet.webs.nf/getuserdetails.php?token=' .$_GET['userToken']);
$apidecoded = json_decode($api, true);
if(isset($apidecoded['success']) && $apidecoded['success'] == 0){
    exit("Wrong token.");
}
//if($apidecoded['authorized_usered'] !== "true"){
//    http_response_code(403);
//    exit("<html><head><title>Whoops!</title><link rel='stylesheet' href='/css/usered-framework.css'></head><body><h1 class='redtext'>Oh no</h1><p class='redtext'>Looking for technical preview? Well, it closed! Thank you for using our technical preview (and giving us feedback)! Using this, we will improve Usered!</p></body></html>");
//}
$q = $conn->prepare("SELECT * FROM `user` WHERE `username`=:username");
$q->execute([
    "username" => $apidecoded['username']
]);
$r = $q->fetch();
if(empty($r)){
    $rg = $conn->prepare("INSERT INTO `user`(username) VALUES(:username)");
    $rg->execute([
        "username" => $apidecoded['username']
    ]);
    header("Location: https://" . $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']."?new=1");
}
$q2 = $conn->prepare("SELECT * FROM `bans` WHERE `target`=:target");
$q2->execute([
    "target" => $r['id']
]);
$r2 = $q2->fetch();
if($r2){?>
<head>
    <title>Banned - Usered</title>
    <!-- <link rel="stylesheet" href="css/yt-framework.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="/js/bootstrap-alert.js"></script>
    <script src="/js/jquery-ui-config.js"></script>
    <script src="/js/dropdown.js"></script>
    <script src="/js/toggle-buttons.js"></script>

    	<!-- Prettify code -->
		<link rel="stylesheet" href="https://google-code-prettify.googlecode.com/svn/trunk/src/prettify.css">
    <script src="https://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
    <style>
    	pre.prettyprint, code {
    		border-color:#EBEBEB;
    		border:1px dashed #BBBBBB;
    		border-left:5px solid #EBEBEB;
    	}
    </style>
    <link rel="stylesheet" href="/css/usered-framework.css">
    <link rel="icon" type="image/png" href="/img/fav.png">

</head>
<body>
<div class="google-header-bar">
    <div class="header content clearfix">
      <a href="/"><img class="logo" alt="Usered" src="/img/logo.png" height="50px"></a>
    </div>
</div>
<div class="main content clearfix">
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="redtext">You have been banned.</h1>
            <br>
            <p class="redtext">You have been banned from Usered for this reason: <?= $r2['reason'] ?></p>
            <h2 class="redtext"><b>Next time, read the rules before going to a social network.</b></h2>
      </div>
  </div>
</div>
</body>
<?php    exit;
}
$utilsClass = new Utils;
$token = $utilsClass->tokenGen();
$q = $conn->prepare("INSERT INTO tokens(user, token) VALUES(:user_id, :token)");
$q->execute([
    "user_id" => $r['id'],
    "token" => $token
]);
$_SESSION['token'] = $token;
setcookie("readme", "DO-NOT-SHARE-YOUR-COOKIES");
if($_GET['new']==1){
    $q = $conn->prepare("UPDATE `user` SET `new`=0 WHERE `id`=:id");
    $q->execute([
        "id" => $r['id']
    ]);
    header("Location: /oobe");
    exit;
}else if($r['new']==1){
    $q = $conn->prepare("UPDATE `user` SET `new`=0 WHERE `id`=:id");
    $q->execute([
        "id" => $r['id']
    ]);
    header("Location: /oobe");
    exit;
}
header("Location: /");