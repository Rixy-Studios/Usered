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
      <span class="signup-button"><a id="link-signup" class="g-button g-button-red" href="https://pi.rixynet.webs.nf/link.php?appid=8">Login</a></span>
    </div>
</div>
<div class="main content clearfix">
    <? $useneko = true; require_once "elements/sidebar.php"; ?>
    <div class="product-info oz">
        <h1 class="bluetext">Welcome to Usered.</h1>
        <p>Usered is a <b>brand new</b> social created from the ground up <b>without internal code bloat, no javascripts, just pure CSS and html.</b> Say goodbye to lags!</p>
        <h1 class="bluetext">Features</h1>
        <ul class="plus-features clearfix">
          <li class="circles yt-tooltip" title="You can make this evolve into something bigger using feedback. We love this <3"><h3>By everybody</h3></li>
          <li class="hangouts yt-tooltip" title="Share you content to everyone."><h3>Global feed & personal feed</h3></li>
          <li class="photo yt-tooltip" title="You can embed photos & videos to your Reeds."><h3>Photos & videos</h3></li>
        </ul>
    </div>
</div>
<?php
require_once "elements/footer.php";
?>