<?php
$activePage = "community";
include("./top.php");

$followers_list = "";
$following_list ="";
$error = "";
$success = "";

if(strlen($_GET["followers"]) or strlen($_GET["following"])){
    $followers_list = $_GET["followers"];
    $following_list = $_GET["following"];

}




if(isset($_POST["followBtn"])){
    $toFollow =  $_POST["followBtn"];
    $followTime = date('Y-m-d H:i:s');
    $userid = $row["memberID"];
    $stmt = $db->prepare('INSERT INTO following (user_id,follower_id,time) VALUES (:userid, :followid, :time)');
			$stmt->execute(array(
                ':userid' => $userid,
				':followid' => $toFollow,
				':time' => $followTime
           ));
    $success = "Your now following this person";
    
}
if(isset($_POST["unfollowBtn"])){
    $unFollow =  $_POST["unfollowBtn"];
    $userid = $row["memberID"];
    
    $stmtUnFollow = $db->prepare('DELETE FROM following WHERE user_id = :userid AND follower_id = :followid');
			$stmtUnFollow->execute(array(
                ':userid' => $userid,
				':followid' => $unFollow
           ));
 
    $error = "Your now unfollow this person!";
}
?> 
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Followers</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            Community
                        </li>
                        <li class="active">
                            <strong>Followers</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <?php
                if(strlen($error) > 1){
                    ?>
                
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                    <?=$error?>
                </div>
               <? }
                if(strlen($success) > 1){?>
                 <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                    <?=$success?>
                </div>
                <?}?>
                     </div>
                    
        <div class="row">
            <?php
            
            if($following_list > 0){
                //geef de lijst weer van iedereen die hij volgt 
                    //geef het gehele netwerk weer. 
               $sql = "SELECT * FROM following WHERE user_id='$following_list'";
                $stmt = $db->query($sql);
        

                
                    // output data of each row
                    while($rij = $stmt->fetch()) {
                        echo '<div class="col-lg-3">
                    <div class="contact-box center-version">

                        <a href="profile.php?profile='.getUsername($rij["follower_id"]).'">

                            <img alt="image" class="img-circle" src="'.getAvatar($rij["follower_id"]).'">


                            <h3 class="m-b-xs"><strong>'.getUsername($rij["follower_id"]).'</strong></h3>

                            <div class="font-bold">';
                                
                        
                       
                            
                            echo '</div>
                           

                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                            <form method="post" action="">
                            ';
                        $followersid = $rij["memberID"];
                        $memberID = $row["memberID"];
                        
                        $new = "SELECT * FROM following WHERE user_id = '$memberID' AND follower_id = '$userid'";
                        $stmtF = $db->prepare($new);
                        $stmtF-> execute();
                        $info = $stmtF->rowCount();

                        if ($info == 1){
                            echo '  <button class="btn btn-md btn-danger" type="submit" name="unfollowBtn" value="'.$rij["memberID"].'"><i class="fa fa-user-min"></i> Unfollow</button>';
                        }else{
                        //nieuwe elseif functie om te kijken of diegene de persoon al volgt. 
                        //lijst aanmaken om te alle al volgende te vinden. 
                        
                        echo' <button class="btn btn-md btn-white" type="submit" name="followBtn" value="'.$rij["memberID"].'"><i class="fa fa-user-plus"></i> Follow</button>';
                        }
                        echo'
                                </form>
                            </div>
                        </div>

                    </div>
                </div>';
                        
                    } 
                
            
            }elseif($followers_list > 0){
                //geef dan lijst weer van iedereen die hem volgt. 
                    //geef het gehele netwerk weer. 
               $sql = "SELECT * FROM following WHERE follower_id ='$followers_list'";
                $stmt = $db->query($sql);
        

                
                    // output data of each row
                    while($rij = $stmt->fetch()) {
                        echo '<div class="col-lg-3">
                    <div class="contact-box center-version">

                        <a href="profile.php?profile='.getUsername($rij["user_id"]).'">

                            <img alt="image" class="img-circle" src="'.getAvatar($rij["user_id"]).'">


                            <h3 class="m-b-xs"><strong>'.getUsername($rij["user_id"]).'</strong></h3>

                            <div class="font-bold">';
                                
                        
                       
                            
                            echo '</div>
                           

                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                            <form method="post" action="">
                            ';
                        $followersid = $rij["memberID"];
                        $memberID = $row["memberID"];
                        
                        $new = "SELECT * FROM following WHERE user_id = '$memberID' AND follower_id = '$userid'";
                        $stmtF = $db->prepare($new);
                        $stmtF-> execute();
                        $info = $stmtF->rowCount();

                        if ($followers_list == $memberID){
                            echo '  <button class="btn btn-md btn-danger" type="submit" name="unfollowBtn" value="'.$rij["memberID"].'"><i class="fa fa-user-min"></i> Unfollow</button>';
                        }else{
                        //nieuwe elseif functie om te kijken of diegene de persoon al volgt. 
                        //lijst aanmaken om te alle al volgende te vinden. 
                        
                        echo' <button class="btn btn-md btn-white" type="submit" name="followBtn" value="'.$rij["memberID"].'"><i class="fa fa-user-plus"></i> Follow</button>';
                        }
                        echo'
                                </form>
                            </div>
                        </div>

                    </div>
                </div>';
                        
                    } 
                
                
                
                
            }else{
                //geef het gehele netwerk weer. 
               $sql = "SELECT * FROM members";
                $stmt = $db->query($sql);
        

                
                    // output data of each row
                    while($rij = $stmt->fetch()) {
                        echo '<div class="col-lg-3">
                    <div class="contact-box center-version">

                        <a href="profile.php?profile='.$rij["username"].'">

                            <img alt="image" class="img-circle" src="'.getAvatar($rij["memberID"]).'">


                            <h3 class="m-b-xs"><strong>'.$rij["username"].'</strong></h3>

                            <div class="font-bold">';
                                
                        
                       
                            
                            echo '</div>
                           

                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                            <form method="post" action="">
                            ';
                        $followersid = $rij["memberID"];
                        $memberID = $row["memberID"];
                        
                        $new = "SELECT * FROM following WHERE user_id = '$memberID' AND follower_id = '$followersid'";
                        $stmtF = $db->prepare($new);
                        $stmtF-> execute();
                        $info = $stmtF->rowCount();

                        if ($info == 1){
                            echo '  <button class="btn btn-md btn-danger" type="submit" name="unfollowBtn" value="'.$rij["memberID"].'"><i class="fa fa-user-min"></i> Unfollow</button>';
                        }else{
                        //nieuwe elseif functie om te kijken of diegene de persoon al volgt. 
                        //lijst aanmaken om te alle al volgende te vinden. 
                        
                        echo' <button class="btn btn-md btn-white" type="submit" name="followBtn" value="'.$rij["memberID"].'"><i class="fa fa-user-plus"></i> Follow</button>';
                        }
                        echo'
                                </form>
                            </div>
                        </div>

                    </div>
                </div>';
                        
                    } 
            }
            
                
                ?>
               
         


        </div>
        </div>
<?php
include("./bottom.php")
?>