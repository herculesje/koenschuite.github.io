<?php
//include config
    require_once('includes/config.php');
    //check if already logged in move to home page
    if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }
    //process login form if submitted
    if(isset($_POST['submit'])){
        if (!isset($_POST['username'])) $error[] = "Please fill out all fields";
        if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
        $username = $_POST['username'];
        if ( $user->isValidUsername($username)){
            if (!isset($_POST['password'])){
                $error[] = 'A password must be entered';
            }
            $password = $_POST['password'];
            if($user->login($username,$password)){
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit;
            } else {
                $error[] = 'Wrong username or password or your account has not been activated.';
            }
        }else{
            $error[] = 'Usernames are required to be Alphanumeric, and between 3-16 characters long';
        }
    }//end if submit
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CoinDOK | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="green-bg">

     <h1 class="logo-name">onWork</h1>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="alert alert-info alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                Please be aware that your username is case sensitive
            </div>
            <h3>Sign in for CoinDok</h3>
           
            <form class="m-t" role="form" method="POST" action="" autocomplete="off">
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
						case 'resetAccount':
							echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}
				}
				
				?>

                <div class="form-group">
                    <input type="input" name="username" id="username" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" name="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
            </form>
            <p class="m-t"> <small>We are made for you!</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
