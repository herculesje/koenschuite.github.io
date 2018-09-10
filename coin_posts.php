<?php
$activePage = "dashboard";

include("top.php");


$coin_name = $_GET['name'];

$coin_details = infoCoin($coin_name);

foreach($coin_details as $coinStat){

if($coinStat["id"] == $coin_name ){
        $error = '';
        $success = '';
          $coinFollow =  $coin_name;
            $followTime = date('Y-m-d H:i:s');
            $userid = $row["memberID"];
    //check if the user online is following the coin
    

        if(isset($_POST["followCoinBtn"])){
      try{
          $stmt = $db->prepare('INSERT INTO coin_follow (memberID,coin,date) VALUES (:userid, :followid, :time)');
                    $stmt->execute(array(
                        ':userid' => $userid,
                        ':followid' => $coinFollow,
                        ':time' => $followTime
                   ));
            
            $lastId = $db->lastInsertId('id');
            $action = 1;
            $tableFollow = 'coin_follow';
            
            
            //add an activity to database. 1= added. 2=changed, 3=deleted 
            $sqlActivity = 'INSERT INTO activity (memberID, location, tableID, time, action) VALUES (:userid, :table, :lastId, :followTime, :action)';
             $stmt = $db->prepare($sqlActivity);
                    $stmt->execute(array(
                        ':userid' => $userid, 
                        ':table' => $tableFollow,
                        ':lastId' => $lastId,
                        ':followTime' => $followTime,
                        ':action' => $action
                        
                  
                   ));
          $success = "You are now following this coin!";

          
      }
          catch(Exception $e){
    //An exception has occured, which means that one of our database queries
    //failed.
    //Print out the error message.
    echo $e->getMessage();
    
}
      
            
        }
        if(isset($_POST["unfollowBtn"])){


            $stmtUnFollow = $db->prepare('DELETE FROM coin_follow WHERE memberID = :userid AND coin = :followid');
                    $stmtUnFollow->execute(array(
                        ':userid' => $userid,
                        ':followid' => $coinFollow
                   ));
            $lastId = 0;
            $action = 3;
            $tableFollow = 'coin_follow';
            
            
            //add an activity to database. 1= added. 2=changed, 3=deleted 
            $sqlActivity = 'INSERT INTO activity (memberID, location, tableID, time, action) VALUES (:userid, :table, :lastId, :followTime, :action)';
             $stmt = $db->prepare($sqlActivity);
                    $stmt->execute(array(
                        ':userid' => $userid, 
                        ':table' => $tableFollow,
                        ':lastId' => $lastId,
                        ':followTime' => $followTime,
                        ':action' => $action
                        
                  
                   ));

            $error = "Your stopped following this coin!";
        }
    
    if(isset($_POST["submit"])){
        
        if(strlen($_POST["status"]) > 15){
            $success = "Your post have been added to the wall. ";
            
            $postContent = $_POST["status"];
            
            
            //add the post to the database
             $stmt = $db->prepare('INSERT INTO coin_post (memberID,coin,post,date) VALUES (:userid, :followid,:post, :time)');
                    $stmt->execute(array(
                        ':userid' => $userid,
                        ':followid' => $coinFollow,
                        ':post' => $postContent,
                        ':time' => $followTime
                   ));
            
            
            //missings variables for activity
             $lastId = $db->lastInsertId('id');
            $action = 1;
            $tableFollow = 'coin_post';
            
            
            //add an activity to database. 1= added. 2=changed, 3=deleted 
            $sqlActivity = 'INSERT INTO activity (memberID, location, tableID, time, action) VALUES (:userid, :table, :lastId, :followTime, :action)';
             $stmt = $db->prepare($sqlActivity);
                    $stmt->execute(array(
                        ':userid' => $userid, 
                        ':table' => $tableFollow,
                        ':lastId' => $lastId,
                        ':followTime' => $followTime,
                        ':action' => $action
                        
                  
                   ));
            
        }else{
            $error = "You post should be more than 15 characters";
        }
        
    }
    
    if(isset($_POST["submitComment"])){
        
        if(strlen($_POST["commentPost"]) > 15){
            $success = "Your comment has been added to the post. ";
            
            $commentContent = $_POST["commentPost"];
            $postID = $_POST["postID"];
            
            
            //add the post to the database
             $stmt = $db->prepare('INSERT INTO coin_post_comments (memberID,postID,content,date) VALUES (:userid, :followid,:post, :time)');
                    $stmt->execute(array(
                        ':userid' => $userid,
                        ':followid' => $postID,
                        ':post' => $commentContent,
                        ':time' => $followTime
                   ));
            
            
            //missings variables for activity
             $lastId = $db->lastInsertId('id');
            $action = 1;
            $tableFollow = 'coin_post_comment';
            
            
            //add an activity to database. 1= added. 2=changed, 3=deleted 
            $sqlActivity = 'INSERT INTO activity (memberID, location, tableID, time, action) VALUES (:userid, :table, :lastId, :followTime, :action)';
             $stmt = $db->prepare($sqlActivity);
                    $stmt->execute(array(
                        ':userid' => $userid, 
                        ':table' => $tableFollow,
                        ':lastId' => $lastId,
                        ':followTime' => $followTime,
                        ':action' => $action
                        
                  
                   ));
            
        }else{
            $error = "You post should be more than 15 characters";
        }
        
    }
    
    //check how many coins the owner has, 
?>
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
                <?}?>
                    </div>
                </div>

            <div class="row m-b-lg m-t-lg">
                <div class="col-md-6">

                    <div class="profile-image">
                        <img src="https://files.coinmarketcap.com/static/img/coins/64x64/<?=$coinStat["id"]?>.png" class="img-circle  m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?=$coinStat["name"]?> 
                                </h2>
                                <h4><?=dollar($coinStat["price_usd"])?> (<?=$coinStat["percent_change_1h"]?>)</h4>
                                <small>
                                    <form action="" method="post">
                                        <? 
                                            
                                            $new = "SELECT * FROM coin_follow WHERE memberID = '$userid' AND coin = '$coinFollow'";
                                            $stmtF = $db->prepare($new);
                                            $stmtF-> execute();
                                            $info = $stmtF->rowCount();

                                            if ($info >= 1){
                                                echo '  <button class="btn btn-md btn-danger" type="submit" name="unfollowBtn" "><i class="fa fa-user-min"></i> Unfollow</button>';
                                            }else{
                                            //nieuwe elseif functie om te kijken of diegene de persoon al volgt. 
                                            //lijst aanmaken om te alle al volgende te vinden. 

                                            echo' <button class="btn btn-md btn-primary" type="submit" name="followCoinBtn" "><i class="fa fa-user-plus"></i> Follow</button>';
                                               
                                            }
        
        ?>
                                    </form>
                                    
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                                <strong><?=number_format($coinStat["24h_volume_usd"])?></strong> 24H volume USD
                            </td>
                            <td>
                                <strong><?=number_format($coinStat["market_cap_usd"])?></strong> Market Cap USD
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong><?=number_format($coinStat["available_supply"])?></strong> Available supply
                            </td>
                            <td>
                                 <strong><?=number_format($coinStat["max_supply"])?></strong> Maximum supply
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong><?=number_format($coinStat["total_supply"])?></strong> Total Supply
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
             


            </div>
            <div class="row">

                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-content">
                                <h3><?=$coinStat["name"]?> </h3>
                            <?
                            //kijken of er berichten naar elkaar verstuurd zijn. 
                            $queryDetails = "SELECT * FROM coin_details WHERE coin='$coinFollow'";
                            $stmtDetails = $db->query($queryDetails);
                            $stmtDetailsCount = $db->query($queryDetails);
                    
                            $countDetail = $stmtDetailsCount->rowCount();
    
                            if($countDetail === 0){
                                echo "We havent found it";
                            }else{
                                while($detailInfo = $stmtDetails->fetch()){
                                ?>
                            
                            <div class="row">
                               <div class="col-md-1">
                                   <i class="fa fa-external-link"></i>
                                </div>
                                <div class="col-md-9">
                                    <a href='<?=$detailInfo["website"]?>' target="_blank"><?=$coinStat["name"]?></a><br />
                                </div>
                            </div> 
                            <div class="row">
                               <div class="col-md-1">
                                   <i class="fa fa-file-o"></i>
                                </div>
                                <div class="col-md-9">
                                    <a href='<?=$detailInfo["whitepaper"]?>' target="_blank">WhitePaper</a><br />
                                </div>
                            </div>
                           <?
                            }
                            }?>
                      
                            

                            <p class="small font-bold" style="margin-top:7px;">
                                <span> Go to more detailed overview</span>
                                </p>

                        </div>
                        </div>
                  
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Supports</h3>
                            <p class="small">
                                Curious on who supports this coin , check it out and talk together about your opinion about the coin
                            </p>
                            
                            <div class="user-friends">
                                <?
                            //kijken of er berichten naar elkaar verstuurd zijn. 
                            $queryFollows = "SELECT * FROM coin_follow WHERE coin='$coinFollow'";
                            $stmtFollows = $db->query($queryFollows);
                            $stmtFollowsCount = $db->query($queryFollows);
                    
                            $num_rows = count($stmtFollowsCount->fetchColumn());
    
                            if($num_rows > 0){
    
                            while($followsDetail = $stmtFollows->fetch()) {
                                ?>
                                <a href="profile.php?name=<?=getUsername($followsDetail["memberID"])?>"><img alt="image" class="img-circle" src="<?=getAvatar($followsDetail["memberID"])?>"></a>
                                <?
                            }}else{
                                echo "No one is currently supporting this coin!";
                            }
                                
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Most liked articles</h3>
                            <ul class="list-unstyled file-list">
                                <li><a href=""><i class="fa fa-file"></i> Project_document.docx</a></li>
                                <li><a href=""><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
                                <li><a href=""><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
                                <li><a href=""><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
                                <li><a href=""><i class="fa fa-file-powerpoint-o"></i> Presentation.pptx</a></li>
                                <li><a href=""><i class="fa fa-file"></i> 10_08_2015.docx</a></li>
                            </ul>
                        </div>
                    </div>
                    -->

                

                </div>
                <div class="col-lg-9">
                           
                    <!-- Hier moet de POST sectie komen die zichtbaar is voor leden om nieuwe posts te maken --> 
                     <div class="posts">
                         <div class="create-posts">
                          <form action="" method="post" enctype="multipart/form-data">
                       
                          <div class="c-body">
                           <div class="body-left">
                            <div class="img-box">
                             <img src="<?=getAvatar($userid)?>" />

                            </div>
                           </div>
                           <div class="body-right">
                            <textarea class="text-type" name="status" placeholder="What's your opinion about this coin?"></textarea>
                           </div>
                           <div id="body-bottom">
                           <img src="#"  id="preview"/>
                           </div>
                          </div>
                          <div class="c-footer">
                            
                       
                            
                             <input type="submit" name="submit" value="Post" class="btn btn-primary pull-right" style="margin:7px;"/>
                            
                         

                           </div>
                          </div>
                          </div>
                      <script type="text/javascript">
                           //Image Preview Function
                            $("#uploadTrigger").click(function(){
                               $("#uploadFile").click();
                            });
                                  function readURL(input) {
                                      if (input.files && input.files[0]) {
                                          var reader = new FileReader();

                                          reader.onload = function (e) {
                                           $('#body-bottom').show();
                                              $('#preview').attr('src', e.target.result);
                                          }

                                          reader.readAsDataURL(input.files[0]);
                                      }
                                  }

                            </script>


            
                            <?php
              //let the magic happen and display all the coins
                           
                          //kijken of er berichten naar elkaar verstuurd zijn. 
                    $queryPosts = "SELECT * FROM coin_post WHERE coin='$coinFollow' ORDER BY date DESC";
                     $stmtM = $db->query($queryPosts);
                    
                                   
                    // output data of each row
                    while($postDetail = $stmtM->fetch()) {

            
            
            ?>
    
    
                         <div class="social-feed-box">

                            <div class="pull-right social-action dropdown">
                                <button data-toggle="dropdown" class="dropdown-toggle btn-white">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu m-t-xs">
                                    <li><a href="#">Delete Post</a></li>
                                </ul>
                            </div>
                            <div class="social-avatar">
                                <a href="" class="pull-left">
                                    <img alt="image" src="<?=getAvatar($postDetail["memberID"])?>">
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        <?=getUsername($postDetail["memberID"])?>
                                    </a>
                                    <small class="text-muted"><?=timeAgo($postDetail["date"])?></small>
                                </div>
                            </div>
                            <div class="social-body">
                                <br>
                                <p>
                                     <?=$postDetail["post"]?>
                                </p>
                                <div class="btn-group">
                                    
                                </div>
                            </div>
                            <div class="social-footer">

                                  <?php
              //let the magic happen and display all the coins
                           
                          //kijken of er berichten naar elkaar verstuurd zijn. 
                $postID = $postDetail["id"];
                    $queryComment = "SELECT * FROM coin_post_comments WHERE postID='$postID' ";
                     $stmtC = $db->query($queryComment);
                    
                                   
                    // output data of each row
                    while($commentDetail = $stmtC->fetch()) {

            
             
                                ?>
                                <div class="social-comment">
                                    <a href="" class="pull-left">
                                        <img alt="image" src="<?=getAvatar($commentDetail["memberID"])?>">
                                    </a>
                                    <div class="media-body">
                                        <a href="#">
                                            <?=getUsername($commentDetail["memberID"])?>
                                        </a>
                                        <?=$commentDetail["content"]?>
                                        <br/>
                                        <a href="#" class="small"><i class="fa fa-thumbs-up"></i> 11 Like this!</a> -
                                        <small class="text-muted"><?=timeAgo($commentDetail["date"])?></small>
                                    </div>
                                </div>
                                <?
                                        }
                                ?>

                                <div class="social-comment">
                                    <form action="" method="post">
                                        <a href="" class="pull-left">
                                            <img alt="image" src="<?=$row["avatar"]?>">
                                        </a>
                                        <div class="media-body">
                                            <div class="form-inline">
                                            <textarea class="form-control comment-field" name="commentPost" style="width:90%;" placeholder="Write comment..."></textarea>
                                                
                                      
                                            <input type="submit" class="btn btn-sm btn-primary pull-right" name="submitComment" value="Post">
                                                <input type="hidden" value="<?=$postID?>" name="postID">
                                                </div>
                                        </div>
                                        
                                    </form>
                                    
                                </div>
                            </div>
                        </div>

                        
                    <?
                        }
            ?>
                </div>
                    


                    


        
           
   <?php
}else{
    ?>
    <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                    The coin you searching for is not found!
    </div>
<?
}
}
include("bottom.php");
?>
<script>
   $(document).ready(function(){
 $(".delete_class").click(function(){
   var del_id = $(this).attr('id');
   $.ajax({
      type:'POST',
      url:'delete_post.php',
      data:'delete_id='+del_id,
      success:function(data) {
        if(data) {   // DO SOMETHING
        } else { // DO SOMETHING }
      }
   });
 });
}); 
</script>