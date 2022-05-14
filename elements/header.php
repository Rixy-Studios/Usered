<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) ) {
    exit("Get a mother");
}
if(!isset($conn)){
    exit("This element needs the conn variable.");
}
if(!isset($userClass)){
    exit("This element needs the user class.");
}
if(!isset($banClass)){
    exit("This element needs the ban class.");
}
if(isset($_SESSION['token'])){
    $user = $userClass->getUserFromToken($conn, $_SESSION['token']);
}else{
    exit(header("Location: /login"));
}
$if_ban = $banClass->checkBan($conn, $user['id']);
if($if_ban){
    $ban = $banClass->getBan($conn, $user['id']);?>
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
<?php   exit();
}
?>
<html>
<head>
    <title><?php if(isset($title)){echo $title. " - Usered";}else{echo "Usered";} ?></title>
    <link rel="stylesheet" href="/css/yt-framework.css">
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
    <? if(substr($_SERVER['REQUEST_URI'], 0, 8 ) !== "/profile" && substr($_SERVER['REQUEST_URI'], 0, 10 ) !== "/blog_post"){ ?>
    <? if($user['c_css_everywhere']==1){ ?>
    <style>
        <?= $user['css'] ?>
    </style>
    <? } ?>
    <? } ?>
</style>
</head>
<body>
 <div class="wrapper">
  <ul class="yt-navigation-dark">
      <li class="selected" onclick="window.location.href='/'">Usered</li>
      <li onclick="window.location.href='https://pi.rixynet.webs.nf'">Riiset</li>
      <li onclick="window.location.href='https://noted.webs.nf'">Noted</li>
  </ul>
<div class="google-header-bar">
    <div class="header content clearfix">
      <a href="/"><img class="logo" alt="Usered" src="/img/logo.png" height="50px"></a>
      <div class="button-container-idk">
        <a class="g-button g-button-submit" href="/profile/<?= $user['id'] ?>">Profile</a>
        <a class="g-button g-button-submit" href="/blog_post/create">Create a blog post</a>
        <? if($user['perms']==1){ ?><a class="g-button g-button-submit" href="/admin">Admin panel</a><? } ?>
      </div>
      <span class="signup-button"><a id="link-signup" class="g-button g-button-red" href="/logout">Logout</a></span>
    </div>
</div>