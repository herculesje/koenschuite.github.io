
<?php
require_once 'include/config.php';  
 
//if logged in check for rows that are connected to this user

$username = $_SESSION['username'];

$new = "SELECT * FROM members where username = '$username'";
$stmt = $db->prepare($new);
$stmt-> execute();
$row = $stmt->fetch();
//$result = $display->fetch_assoc();
   

$memberID = $row["memberID"];

 if(isset($_POST['Submit']))
    {
        
        $images=$_FILES["image"]["name"];
$image_tmp = $_FILES['image']['tmp_name'];
    if($images=='')    {
        echo "<script>alert('Please Choose Images')</script>";    
        echo "<script>window.open('index.php','_self')</script>";    
    }
else {    try{
               move_uploaded_file($image_tmp,"uploads/$images");
            $stmt = $db->prepare("INSERT INTO members(avatar) VALUES( :image) WHERE memberID = $memberID");
           
            $stmt->bindParam(":image", $images);
if($stmt->execute())
            {
                echo "<script>alert('Successfully Added..')</script>";    
        echo "<script>window.open('index.php','_self')</script>";
            }
            else{
                echo "Query Problem";
            }    
        }
        catch(PDOException $e){
            echo $e->getMessage();
        
    }}
    }
?>

