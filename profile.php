<?php
include("top.php");

$profile = $_GET['profile'];

$new = "SELECT * FROM members where username = '$profile'";
$stmt = $db->prepare($new);
$stmt-> execute();
$rowUser = $stmt->fetch();

$memberID = $row["memberID"];

$profileUser = $rowUser["memberID"];




                        $queryF = "SELECT * FROM following WHERE user_id = '$memberID'";
                        $stmtF = $db->prepare($queryF);
                        $stmtF-> execute();
                        $following = $stmtF->rowCount();

//how many following
                        $fing = "SELECT * FROM following WHERE follower_id = '$memberID'";
                        $stmtFing = $db->prepare($fing);
                        $stmtFing-> execute();
                        $followers = $stmtFing->rowCount();
                        
?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Extra Pages</a>
                        </li>
                        <li class="active">
                            <strong>Profile</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
           <div class="wrapper wrapper-content animated fadeInRight">


            <div class="row m-b-lg m-t-lg">
                <div class="col-md-6">

                    <div class="profile-image">
                        <img src="<?=getAvatar($profileUser)?>" class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?=getUsername($profileUser)?>
                                </h2>
                                <h4>Founder of Groupeq</h4>
                                <small>
                                    There are many variations of passages of Lorem Ipsum available, but the majority
                                    have suffered alteration in some form Ipsum available.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                                <strong><??></strong> Posts
                            </td>
                            <td>
                                <strong>22</strong> Followers
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>61</strong> Comments
                            </td>
                            <td>
                                <strong>54</strong> Articles
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>154</strong> Tags
                            </td>
                            <td>
                                <strong>32</strong> Friends
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <small>Sales in last 24h</small>
                    <h2 class="no-margins">206 480</h2>
                    <div id="sparkline1"></div>
                </div>


            </div>
            <div class="row">

                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-content">
                                <h3>About <?=getUsername($profileUser)?></h3>

                            <p class="small">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form, by injected humour, or randomised words which don't.
                                <br/>
                                <br/>
                                If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't
                                anything embarrassing
                            </p>

                            <p class="small font-bold">
                                <span><i class="fa fa-circle text-navy"></i> Online status</span>
                                </p>

                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Followers and friends</h3>
                            <p class="small">
                                If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't
                                anything embarrassing
                            </p>
                            <div class="user-friends">
                                <?
                            //kijken of er berichten naar elkaar verstuurd zijn. 
                            $queryFollows = "SELECT * FROM following WHERE follower_id='$profileUser'";
                            $stmtFollows = $db->query($queryFollows);
                            $stmtFollowsCount = $db->query($queryFollows);
                    
                            $num_rows = count($stmtFollowsCount->fetchColumn());
    
                            if($num_rows > 0){
    
                            while($followsDetail = $stmtFollows->fetch()) {
                                ?>
                                <a href="profile.php?profile=<?=getUsername($followsDetail["user_id"])?>"><img alt="image" class="img-circle" src="<?=getAvatar($followsDetail["user_id"])?>"></a>
                                <?
                            }}else{
                                echo "No one is currently supporting this coin!";
                            }
                                
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Personal friends</h3>
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

                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Private message</h3>

                            <p class="small">
                                Send private message to Alex Smith
                            </p>

                            <div class="form-group">
                                <label>Subject</label>
                                <input type="email" class="form-control" placeholder="Message subject">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" placeholder="Your message" rows="3"></textarea>
                            </div>
                            <button class="btn btn-primary btn-block">Send</button>

                        </div>
                    </div>

                </div>

                <div class="col-lg-5">
                        <?php
              //let the magic happen and display all the coins
                           
                          //kijken of er berichten naar elkaar verstuurd zijn. 
                    $queryPosts = "SELECT * FROM coin_post WHERE memberID='$memberID' ORDER BY date DESC LIMIT 5";
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
                                            <textarea class="form-control comment-field" name="commentPost" style="width:86%;" placeholder="Write comment..."></textarea>
                                                
                                      
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
                <div class="col-lg-4 m-b-lg">
                    <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon navy-bg">
                                <i class="fa fa-briefcase"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Meeting</h2>
                                <p>Currently holding a meeting with the partners of Ripple, they try to bond with another cryptocoin .
                                </p>
                                <a href="#" class="btn btn-sm btn-primary"> More info</a>
                                    <span class="vertical-date">
                                        Today <br>
                                        <small>Dec 24</small>
                                    </span>
                            </div>
                        </div>

                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon blue-bg">
                                <i class="fa fa-file-text"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Uploaded Documents</h2>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
                                <a href="#" class="btn btn-sm btn-success"> Download document </a>
                                    <span class="vertical-date">
                                        Today <br>
                                        <small>Dec 24</small>
                                    </span>
                            </div>
                        </div>

                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon lazur-bg">
                                <i class="fa fa-coffee"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Reached $1,000 mark</h2>
                                <p>Your portfolio has reach the benchmark of 1,000$ congrats.. </p>
                                <a href="#" class="btn btn-sm btn-info">Read more</a>
                                <span class="vertical-date"> Yesterday <br><small>Dec 23</small></span>
                            </div>
                        </div>

                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon yellow-bg">
                                <i class="fa fa-phone"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Joined a group</h2>
                                <p>Has joined a new investers group</p>
                                <span class="vertical-date">Yesterday <br><small>Dec 23</small></span>
                            </div>
                        </div>

                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon navy-bg">
                                <i class="fa fa-comments"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>Donator</h2>
                                <p>YOu have donated more than 1$ and are now being displayed in the hall of fame </p>
                                <span class="vertical-date">Yesterday <br><small>Dec 23</small></span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div>
        </div>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Peity -->
    <script src="js/demo/peity-demo.js"></script>

</body>

</html>
