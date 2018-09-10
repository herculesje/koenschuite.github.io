<?php
require('includes/config.php');
//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }
//if form has been submitted process it
if(isset($_POST['submit'])){
	//Make sure all POSTS are declared
	if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(empty($row['email'])){
			$error[] = 'Email provided is not recognised.';
		}
	}
	//if no errors have been created carry on
	if(!isset($error)){
		//create the activation code
		$stmt = $db->prepare('SELECT password, email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$token = hash_hmac('SHA256', $user->generate_entropy(8), $row['password']);//Hash and Key the random data
        $storedToken = hash('SHA256', ($token));//Hash the key stored in the database, the normal value is sent to the user
		try {
			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $storedToken
			));
			//send email
			$to = $row['email'];
			$subject = "Password Reset";
			$body = "<p>Someone requested that the password be reset.</p>
			<p>If this was a mistake, just ignore this email and nothing will happen.</p>
			<p>To reset your password, visit the following address: <a href='".DIR."reset_password.php?key=$token'>".DIR."reset_password.php?key=$token</a></p>";
			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();
			//redirect to index page
			header('Location: login.php?action=reset');
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

                    <h2 class="font-bold">Forgot password</h2>
                    <p><a href='login.php'>Go back to login screen</a></p>
                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>

                    <div class="row">
                        <?php
                                //check for any errors
                                if(isset($error)){
                                    foreach($error as $error){
                                        echo '<p class="bg-danger">'.$error.'</p>';
                                    }
                                }
                                if(isset($_GET['action'])){
                                    //check the action
                                    switch ($_GET['action']) {
                                        case 'active':
                                            echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
                                            break;
                                        case 'reset':
                                            echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
                                            break;
                                    }
                                }
                        ?>

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required="">
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Send new password</button>

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
