<?php
$activePage = "messages";
include("top.php");

$messaging = $_GET["with"];

$queryM = "SELECT * FROM members where username = '$messaging'";
$stmtM = $db->prepare($queryM);
$stmtM-> execute();
$rowM = $stmtM->fetch();

$messagingWithID = $rowM["memberID"];
$userid = $row["memberID"];

if(isset($_POST['sendMessage'])){
    $content = $_POST['messageContent'];
    
    if(strlen($content) > 3){
        
        $sendTime = date('Y-m-d H:i:s');
        $status_sender = 1;
        
        
        
        $stmt = $db->prepare('INSERT INTO messages (sender_id,receiver_id,message, date_send, status_sender) VALUES (:userid, :receiver_id, :message, :sendTime, :status_sender)');
			$stmt->execute(array(
                ':userid' => $userid,
				':receiver_id' => $messagingWithID,
				':message' => $content, 
                ':sendTime' => $sendTime, 
                ':status_sender' => $status_sender
           ));
        
    }
}

?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Messages</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li class="active">
                            <strong>Messages</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-content">
                  <div class="row">
                      
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Messages</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                           
                            <div class="ibox-content">
                                <div class="feed-activity-list">
                                    <?php
                                    //search for all the messages send to different persons
                                    $queryMlist = "SELECT * FROM messages WHERE receiver_id='$userid' OR sender_id='$userid' GROUP BY sender_id";
                                    $stmtMlist = $db->query($queryMlist);
                                    
                                   
                                    // output data of each row
                                    if(count($stmtMlist->fetch()) > 0){
                                    while($rowMList = $stmtMlist->fetch()) {
                                    ?>
                                    
                                     <div class="feed-element">
                                         <a class="normal-a" href="messages.php?with=<?=getUsername($rowMList["sender_id"])?>">
                                        <div>
                                            <small class="pull-right text-navy"><?=timeAgo($rowMList["date_send"])?></small>
                                            <strong><?=getUsername($rowMList["sender_id"])?></strong>
                                            <div><?=$rowMList["message"]?></div>
                                            <small class="text-muted"><?=timeAgo($rowMList["date_send"])?></small>
                                        </div>
                                                </a>
                                    </div>
                                 
                                    <?
                                    }
                                    }else{
                                        ?>
                                       <div class="feed-element">
                                         <a href="">
                                        <div>
                                        
                                            <strong>No messages yet!</strong>
                                            
                                        </div>
                                                </a>
                                    </div>
                                    <?
                                    }
                                    ?>
                                    
                                

                                </div>
                            </div>
                        </div>
                      </div>
                      
                    <?  if(strlen($messaging) > 0){?>
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                                <a class="normal-a" href="profile.php?with=<?=$messaging?>"><h5>Messages with <?=$messaging?></h5></a>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                    <div class="ibox-content">

                        <div>
                <div class="chat-activity-list">
                    <?php
    
                    //kijken of er berichten naar elkaar verstuurd zijn. 
                        $queryMessages = "SELECT * FROM messages WHERE sender_id='$userid' AND receiver_id='$messagingWithID' OR receiver_id='$userid' AND sender_id='$messagingWithID'";
                        $stmtM = $db->query($queryMessages);
                    
                                   
                    // output data of each row
                    while($rowMessage = $stmtM->fetch()) {
                        //als degene die het bericht heeft gestuurd, diegene is die ingelogt is laat dan het balkje aan de rechterkant verschijnen
                        if($rowMessage["sender_id"] == $userid){
                    
                        
                    ?>
                    
                        <div class="chat-element right">
                        <a href="#" class="pull-right">
                            <img alt="image" class="img-circle" src="img/a2.jpg">
                        </a>
                        <div class="media-body text-right ">
                            <small class="pull-left text-navy">1m ago</small>
                            <strong><?=getUsername($rowMessage['sender_id'])?></strong>
                            <p class="m-b-xs">
                                <?=$rowMessage['message']?>
                            </p>
                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                        </div>
                    </div>
                    
                 <?
                    }else{
                ?>
                    <div class="chat-element ">
                        <a href="#" class="pull-left">
                            <img alt="image" class="img-circle" src="img/a2.jpg">
                        </a>
                        <div class="media-body ">
                            <small class="pull-right">2h ago</small>
                            <strong><?=getUsername($rowMessage['sender_id'])?></strong>
                            <p class="m-b-xs">
                                <?=$rowMessage['message']?>
                            </p>
                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                        </div>
                    </div>
                <?    
                        }
                    }
                 ?>
                       
                    
               
                    
             

                    
                </div>
                            
                </div>
                        <div class="chat-form">
                            <form role="form" action="" method="post">
                                <div class="form-group">
                                    <textarea class="form-control" name="messageContent" id="messageContent" placeholder="Message"></textarea>
                                </div>
                                <div class="text-right">
                                    <button type="submit" name="sendMessage" id="sendMessage" class="btn btn-sm btn-primary m-t-n-xs"><strong>Send message</strong></button>
                                </div>
                            </form>
                        </div>
                </div>
                </div>
                      
                      
                
                </div>
                    <?  
                      }else{
                       
                    }
                      ?>
            </div>
   <?php
include("bottom.php");
?>