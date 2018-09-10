<?php require('includes/config.php'); 
//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); exit(); }
$resetToken = hash('SHA256', ($_GET['key']));
$stmt = $db->prepare('SELECT resetToken, resetComplete FROM members WHERE resetToken = :token');
$stmt->execute(array(':token' => $resetToken));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//if no token from db then kill the page
if(empty($row['resetToken'])){
	$stop = 'Invalid token provided, please use the link provided in the reset email.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Your password has already been changed!';
}
//if form has been submitted process it
if(isset($_POST['submit'])){
	if (!isset($_POST['password']) || !isset($_POST['passwordConfirm']))
		$error[] = 'Both Password fields are required to be entered';
	//basic validation
	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}
	//if no errors have been created carry on
	if(!isset($error)){
		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
		try {
			$stmt = $db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));
			//redirect to index page
			header('Location: login.php?action=resetAccount');
			exit;
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Forgot password</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Reset password</h2>
                    <p><a href='login.php'>Go back to login screen</a></p>
                    <p>
                        You've received an email in your mailbox, please click the link to reset your password
                    </p>

                    <div class="row">
                        <?php
					//check for any errors
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<p class="bg-danger">'.$error.'</p>';
                            }
                        }
                        //check the action
                        switch ($_GET['action']) {
                            case 'active':
                                echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
                                break;
                            case 'reset':
                                echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
                                break;
                        }
                        ?>
                        

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Confirm Passwor" required="">
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Change Password</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright CoinDOK
            </div>
            <div class="col-md-6 text-right">
               <small>© 2018</small>
            </div>
        </div>
    </div>

</body>

</html>
