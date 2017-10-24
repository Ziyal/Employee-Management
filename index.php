<?php
//include config
require_once('config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: dashboard.php'); exit(); }

//process login form if submitted
if(isset($_POST['submit'])){
	if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
	$email = $_POST['email'];

	if ( $user->isValidEmail($email)){
		if (!isset($_POST['password'])){
			$error[] = 'A password must be entered';
		}
		$password = $_POST['password'];
		if($user->login($email, $password)){
			$_SESSION['username'] = $email;
			header('Location: dashboard.php');
			exit;
		} else {
			$error[] = 'Incorrect email or password';
		}
	} else{
		$error[] = 'Invalid email';
	}
}

//define page title
$title = 'Employee Management';
?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="style/main.css">
    </head>
    <body>
        <div class="container">
            <div class="welcome-text">
                <h1>Welcome!</h1>
                <h2>Please sign in to continue</h2>
            </div>

            <div class="login-form">
                <form action="" method="post">
                    <input type="text" name="email" placeholder="Email" class="l-input form-control">
                    <input type="password" name="password" placeholder="Password" class="l-input form-control">
                    <input type="submit" name="submit" value="Login" class="l-input l-btn btn btn-primary btn-block">
                </form>
            </div>

            <?php
                //check for any errors
                if(isset($error)){
                    foreach($error as $error){
                        echo '<p class="bg-danger error">'.$error.'</p>';
                    }
                }
            ?>

        </div>
    </body>
</html>

<?php
    //include footer template
    require('layout/footer.php');
?>