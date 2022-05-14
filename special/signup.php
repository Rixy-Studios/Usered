<?php
require_once "./utils/database.php";
require_once "./utils/utils.php";
require_once "./database/user.php";
$dbClass = new Database;
$dbClass->init_session();
$conn = $dbClass->connect();
$utilsClass = new Utils;
$userClass = new User;
if(!SIGNUP_AUTHORIZED){
    header("Location: /login");
}
?>
<html>
<head>
    <title>Welcome. - Usered</title>
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
    </div>
</div>
<div class="main content clearfix">
    <div class="sign-in">
        <div class="signin-box">
            <form method="post">
                <div class="email-div">
                    <label for="Username"><strong class="email-label">Username</strong></label>
                    <input type="text" spellcheck="false" name="username" id="Username" value="">
                </div>
                <div class="passwd-div">
                    <label for="Email"><strong class="passwd-label">Email</strong></label>
                    <input type="email" name="email" id="Email">
                </div>
                <div class="passwd-div">
                    <label for="Passwd"><strong class="passwd-label">Password</strong></label>
                    <input type="password" name="password" id="Passwd">
                </div>
                <input type="submit" class="g-button g-button-submit" name="signUp" id="signUp" value="Sign up">
            </form>
            <?php
            if(isset($_POST['signUp'])){
                if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])){
                    $status = $userClass->createUser($conn, $_POST['username'], $_POST['email'], $_POST['password']);
                    if($status=="ALREADY_TAKEN_USERNAME"){
                        echo "<p class='redtext'>This username has already been taken.</p>";
                    }else if($status=="ALREADY_TAKEN_EMAIL"){
                        echo "<p class='redtext'>This email has already been taken.";
                    }else if($status=="OK"){
                        header("Location: /login");
                        exit;
                    }
                }else{
                    echo "<p class='redtext'>You didn't fill out all the fields.</p>";
                }
            }
            ?>
        <ul>
            <li>
                <a id="link-forgot-passwd" href="/login" target="_top">You have an account?</a>
            </li>
        </ul>
        </div>
  </div>
    <div class="product-info oz">
        <h1 class="bluetext">Welcome to Usered.</h1>
        <p>Usered is a <b>brand new</b> social created from the ground up <b>without internal code bloat, no javascripts, just pure CSS and html.</b> Say goodbye to lags!</p>
        <h1 class="bluetext">Features</h1>
        <ul class="plus-features clearfix">
          <li class="circles yt-tooltip" title="You can make this evolve into something bigger using feedback. We love this <3"><h3>By everybody</h3></li>
          <li class="hangouts yt-tooltip" title="Share you content to everyone."><h3>Global feed & personal feed</h3></li>
          <li class="photo yt-tooltip" title="You can embed photos & videos to your Reeds."><h3>Photos & videos</h3></li>
        </ul>
        <b><p class="redtext">+ it is the replacement to Riiset!</p></b>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>