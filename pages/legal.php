<?php
require_once "./utils/database.php";
require_once "./database/user.php";
require_once "./database/dm.php";
$dmClass = new Dm;
$dbClass = new Database;
$dbClass->init_session();
$conn =  $dbClass->connect();
$userClass = new User;
require_once "./database/ban.php";
$banClass = new Ban;
//metadata needed for header
$title = "Legal";
require_once "elements/header.php";
?>
<div class="main content clearfix">
    <div class="product-info oz">
        <div class="product-headers">
            <h1 class="bluetext">Legal</h1>
            <p>This includes legal documents like terms of service, privacy policy, etc.</p>
            <strong>Even if it's boring, please check them regularly.</strong>
            <ul>
                <li><a href="/legal/terms">-Terms of Service</a></li>
                <li><a href="/legal/privacy">-Privacy Policy</a></li>
            </ul>
        </div>  
    </div>        
</div>            
<?php
require_once "elements/footer.php";
?>
