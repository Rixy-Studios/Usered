<?php
/*

Usered login

well, ugly, but better than earlier in the project lmfao
*/
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/ban.php";
require_once "./utils/utils.php";
$dbClass = new Database;
$dbClass->init_session();
$userClass = new User;
$banClass = new Ban;
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

$r = $userClass->getUserFromUsername($conn, $apidecoded['username']);
if(empty($r)){
    $userClass->createUser($conn, $apidecoded['username']);
    header("Location: https://" . $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']."?new=1");
}
$if_ban = $banClass->checkBan($conn, $r['id']);
if($if_ban){
    $ban = $banClass->getBan($conn, $r['id']);?>
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
            <p class="redtext">You have been banned from Usered for this reason: <?= $ban['reason'] ?></p>
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
    $userClass->update($conn, "new", 0, $r['id'], false);
    header("Location: /oobe");
    exit;
}else if($r['new']==1){
    $userClass->update($conn, "new", 0, $r['id'], false);
    header("Location: /oobe");
    exit;
}
header("Location: /");