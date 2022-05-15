<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/blog_post.php";
require_once "./database/misc.php";
require_once "./utils/utils.php";
require_once "./database/dm.php";
$dmClass = new Dm;
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
$bpClass = new BlogPost;
$miscClass = new Misc;
$utilsClass = new Utils;
require_once "./database/ban.php";
$banClass = new Ban;
$blogpost = $bpClass->getBlogPostFromID($conn, $id);
if(!$blogpost){
    exit(require_once "404.php");
}
$tmstp = $miscClass->getTimestampFromDate($conn, $blogpost['date_created']);
$buser = $userClass->getUserFromID($conn, $blogpost['author']);
$if_ban = $banClass->checkBan($conn, $buser['id']);
if($if_ban){
    $ban = $banClass->getBan($conn, $buser['id']);?>
<head>
    <title>User is banned - Usered</title>
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
            <h1 class="redtext">This user have been banned.</h1>
            <br>
            <p class="redtext">This user have been banned from Usered for this reason: <?= $ban['reason'] ?></p>
      </div>
  </div>
</div>
</body>
<?php    exit();
}
//metadata needed for header
$useneko = true;
$title = $blogpost['title'];
require_once "elements/header.php";
?>
<? if($buser['c_css_everywhere']==1){ ?>
    <style>
        <?= $buser['css'] ?>
    </style>
<? } ?>
<div class="main content clearfix">
    <? require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <div class="product-headers">
            <?= !empty($blogpost['banner_url']) ? '<img style="width: 500px;" src="'.$blogpost['banner_url'].'"/>' : '' ?>
            <br>
            <br>
            <h1 class="bluetext"><?= $blogpost['title'] ?></h1>
            <br>
            <h2><i>By <?= $buser['username'] ?>, created the <?= date("l jS\, M \of Y", $tmstp) ?></i></h2>
            <br>
            <?= nl2br($blogpost['content']) ?>
        </div>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>