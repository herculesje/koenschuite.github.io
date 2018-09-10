<?php
$activePage = "Settings";
include("top.php");


$memberID = $row["memberID"];
$profileUrl = $row["avatar"];
$error = "";
$success = "";

//Get all the settings from memberRow 
$email = $row["email"];
$username = $row["username"];



    if(isset($_POST["upload_avatar"])){
            $upload_dir = 'uploads/'; // upload directory
        
            $imgFile = $_FILES['file']['name'];
            $tmp_dir = $_FILES['file']['tmp_name'];
            $imgSize = $_FILES['file']['size']; 
        
           $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

           // valid image extensions
           $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
            
           // rename uploading image
           $userpic = $memberID.".".$imgExt;

           // allow valid image file formats
           if(in_array($imgExt, $valid_extensions)){   
            // Check file size '5MB'
            if($imgSize < 5000000)    {
                move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                
                
                $updateUrl = "http://coindok.com/uploads/".$userpic;
                
                $stmt = $db->prepare('UPDATE members SET  avatar=:upic WHERE memberID=:uid');
                   $stmt->bindParam(':upic',$updateUrl);
                   $stmt->bindParam(':uid',$memberID);
                if($stmt->execute()){
                    $success = "You succesfully added your avatar";
                    
                }else{
                    $error = "Something went wrong, with adding the image to the database";
                }
                
            }
            else{
             $error = "Sorry, your file is too large.";
            }
           }
   
        
    }
                        

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
            <div class="row animated fadeInRight">
               <div class="tabs-container">
                   <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Standard Settings</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Preferences</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <legend class="legend">Profile Settings</legend>
                                    
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <img id="image_upload_preview" src="<?=$profileUrl?>" alt="Your Avatar" class="img-circle" height="124px" width="125px" />
                                        <form id="form1" runat="server" method="post" action="" enctype="multipart/form-data">
                                           <br>
                                            <input type='file' name="file" id="inputFile" class="inputfile"/>
                                            <label for="inputFile" class="btn btn-primary"><i class="fa fa-upload"></i> Choose Avatar</label> <input type="submit" class="btn btn-primary" name="upload_avatar" value="Upload Avatar">
                                            <br>
                                            <br>
                                            
                                        </form>
                                        
                                        </div>
                                        <div class="col-md-8">
                                            <p> 
                                            My advise to you, don't change your name that often. Otherwise your not able to create a own name!
                                            </p>
                                            <br>
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="username">Username</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" placeholder="Username" name="username" id="username" class="form-control" value="<?=$username?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="username">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" placeholder="Email" name="email" id="email" class="form-control" value="<?=$email?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="currency">Currency</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control m-b" name="currency">
                                                            <option value="USD">US Dollars</option>
                                                            <option value="EUR">Euro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="button" name="update_profile" value="Update Profile" class="btn btn-primary">
                                                           </div>

                                            </form>
                                            
                                        
                                        </div>
                                    </div>
                                 
                                    
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="preferences">
                                        <legend>Preferences</legend>
                                        <form>
                                        <div class="control-group">
                                            
                                        <label class="control-label" for="local-currency">Local Currency</label>
                                            <select id="local-currency">
                                                <option>US Dollar</option>
                                                <option>Euros</option>
                                            </select>
                                            </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                </div>
                
                
            </div>
        </div>
      
<?
    include("bottom.php");
    ?>
<!-- Sweet alert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){

    });
        
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function () {
        readURL(this);
        
    });
    
    var inputs = document.querySelectorAll( '.inputfile' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label	 = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener( 'change', function( e )
            {
                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.querySelector( 'span' ).innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });
        });

</script>