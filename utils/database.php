<?php
class Database{
    public function init_session(){
        session_start([
            "cookie_lifetime" => time() + (10 * 365 * 24 * 60 * 60),
        ]);
    }
    public function connect(){
        //swaggish
        require_once "./config.php";
        try {
            $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME , USER, PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {?>
<head>
    <title>Error - Usered</title>
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
            <h1 class="redtext">An error has occured.</h1>
            <br>
            <p class="redtext">Usered failed to connect to the database.</p>
            <h2 class="redtext"><b>This might be an urgent internal issue.</b></h2>
            <i class="redtext">Contact an admin with this error message: <?= $e->getMessage(); ?></i>
      </div>
  </div>
</div>
</body>
            <?php die();
            exit;
        }
        return $db;
    }
}
?>