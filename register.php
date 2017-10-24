<?php require('config.php');

//if form has been submitted process it
if(isset($_POST['submit'])){
    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['first_name'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['last_name'])) $error[] = "Please fill out all fields";
	// $username = $_POST['username'];
	//very basic validation
	if(strlen($_POST['password']) < 5){
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['password_cf']) < 5){
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['password_cf']){
		$error[] = 'Passwords do not match.';
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
			//insert into database with a prepared statement
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
		//else catch the exception and show the error.
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


<html>
    <h1>Add a User</h1>
    <div class="form">
        <form action="" method="post">
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="password_cf" placeholder="Confirm Password">
            <input type="first_name" name="first_name" placeholder="First Name">
            <input type="last_name" name="last_name" placeholder="Last Name">
            <input type="submit" name="submit" value="Create User">
        </form>
    </div>

</html>

<?php
//include footer template
require('layout/footer.php');
?>