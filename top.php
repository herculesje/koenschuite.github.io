<?php
require('includes/config.php'); 
require('includes/functions.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//to select rows

function getData($query)
{
    /* you will have to add error checking here */
    /* you can also do prepared statements here */
    $result = $db->prepare($query);
    $result->execute();
    return($result->fetchAll(PDO::FETCH_ASSOC));
}



//if logged in check for rows that are connected to this user

$username = $_SESSION['username'];

$new = "SELECT * FROM members where username = '$username'";
$stmt = $db->prepare($new);
$stmt-> execute();
$row = $stmt->fetch();
//$result = $display->fetch_assoc();
   

$memberID = $row["memberID"];

$queryCoin = $db->prepare("SELECT * FROM portfolio_coins WHERE memberID = $memberID");
$queryCoin-> execute();

$sumInvested = 0;


while($sumCoin = $queryCoin->fetch() ){
    if($sumCoin["bought_with"] === $row["currency"]){
        $investedAdd = $sumCoin["amount"] * $sumCoin["price_paid"]; 
        
        $sumInvested += $investedAdd;
    }
}


?>



<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Coindok | CryptoNews, Tracking Coins, Predicting Changes</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    
       <link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="css/posts.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/bootstrap-imageupload.css" rel="stylesheet">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    

    

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?=getAvatar($row["memberID"])?>" height="64px" width="64px" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=$row["username"]?></strong>
                             </span> <span class="text-muted text-xs block">
                                
                                Founder 
                                
                                <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.php?profile=<?=$username?>">Profile</a></li>
                            <li><a href="follows.php">Followers</a></li>
                            <li><a href="messages.php">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        DOK
                    </div>
                </li>
                
                <li  <?php if ($activePage =="dashboard") {?>
 class="active" <?php } ?>>
                    <a href="index.php"><i class="fa fa-th-large" ></i> <span class="nav-label">Dashboard</span></a>
                </li>
                
                <li  <?php if ($activePage =="active_prices") {?>
 class="active" <?php } ?>>
                    <a href="active_prices.php"><i class="fa fa-usd"></i> <span class="nav-label">Coins</span></a>
                </li>
                <li  <?php if ($activePage =="portfolio") {?>
 class="active" <?php } ?>>
                    <a href="portfolio.php"><i class="fa fa-line-chart"></i> <span class="nav-label">Portfolio</span></a>
                </li>
                <li <?php if ($activePage =="community") {?>
 class="active" <?php } ?>>
                    <a href="follows.php"><i class="fa fa-users"></i> <span class="nav-label">Community</span></a>
                </li>
                <li  <?php if ($activePage =="messages") {?>
 class="active" <?php } ?>>
                    <a href="messages.php"><i class="fa fa-envelope"></i> <span class="nav-label">Messages</span></a>
                </li>
                <li  <?php if ($activePage =="Settings") {?>
 class="active" <?php } ?>>
                    <a href="settings.php"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span></a>
                </li>
                
        
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
           
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to CoinDOK.</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.php" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">46h ago</small>
                                    <strong><?=$sumInvested?></strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.php" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div>
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.php" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="messages.php">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i> 
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="messages.php">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.php">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>