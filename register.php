<?php require('config.php');

//once form is submitted
if(isset($_POST['submit'])){
    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['first_name'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['last_name'])) $error[] = "Please fill out all fields";

	// validations
	if(strlen($_POST['password']) < 5){
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['password_cf']) < 5){
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['password_cf']){
		$error[] = 'Passwords do not match.';
	}
	if($_POST['first_name'] < 2){
		$error[] = 'First name too is too short';
	}	
	if($_POST['last_name'] < 2){
		$error[] = 'Last name too is too short';
	}	
    
    //email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
	}

	//if no errors have been created carry on
	if(!isset($error)){
		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {
			//enter user into db
			$stmt = $db->prepare('INSERT INTO users (email, password, first_name , last_name) VALUES (:email, :password, :first_name, :last_name)');
			$stmt->execute(array(
				':email' => $email,
				':password' => $hashedpassword,
				':first_name' => $_POST['first_name'],
				':last_name' => $_POST['last_name']
			));
			$id = $db->lastInsertId('id');
			
			//redirect to index page
			header('Location: dashboard.php');
			exit;
		//else catch the exception and show error
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}
//define page title
$title = 'Add User - Employee Management';
//include header template
require('layout/header.php');
?>

<div class="container">
	<div class="register-form">
		<h1 class="admin-title">Add a Admin</h1>
		<form action="" method="post">
			<input type="text" name="email" placeholder="Email" class="a-input form-control">
			<input type="password" name="password" placeholder="Password" class="a-input form-control">
			<input type="password" name="password_cf" placeholder="Confirm Password" class="a-input form-control">
			<input type="text" name="first_name" placeholder="First Name" class="a-input form-control">
			<input type="text" name="last_name" placeholder="Last Name" class="a-input form-control">
			<input type="submit" name="submit" value="Create User" class="a-btn btn btn-block btn-success">
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

<?php
//include footer template
require('layout/footer.php');
?>