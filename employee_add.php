<?php require('config.php');

//once form is submitted
if(isset($_POST['submit'])){
    empty($error);
    if (!isset($_POST['first_name'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['last_name'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['gender'])) $error[] = "Please choose a gender";

    date_default_timezone_set('America/Los_Angeles');
    $todays_date = date('Y-m-d', time());
    
	// validations
    if($_POST['birthday'] > $todays_date) {
        $error[] = 'Birthday must be in the past';
    }
    
    //email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} 

	// enter into db once validations are passed
	if(!isset($error)){
		try {
			//enter employee into db
			$stmt = $db->prepare('INSERT INTO employees (first_name, last_name, birthday, hire_date, email, gender) VALUES (:first_name, :last_name, :birthday, :hire_date, :email, :gender)');
			$stmt->execute(array(
				':first_name' => $_POST['first_name'],
				':last_name' => $_POST['last_name'],
				':birthday' => $_POST['birthday'],
				':hire_date' => $_POST['hire_date'],
				':email' => $_POST['email'],
				':gender' => $_POST['gender']
			));
			
			//redirect to employee page
			header('Location: employees.php');
			exit;

		//else catch the exception and show error
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

    //define page title
    $title = 'Employees - Employee Management';
    //include header template
    require('layout/header.php');
?>

<div class="container">
	<div class="add-employee-form">
		<h1 class="add-employee-title">Add New Employee</h1>
		<form action="" method="post">
			<span class="field-name">First Name: </span><input type="text" name="first_name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['first_name'], ENT_QUOTES); } ?>" class="e-input form-control">
			<span class="field-name">Last Name: </span><input type="text" name="last_name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['last_name'], ENT_QUOTES); } ?>" class="e-input form-control">
			<span class="field-name">Birthday: </span><input type="date" name="birthday" class="e-input form-control">
			<span class="field-name">Date of Hire: </span><input type="date" name="hire_date" class="e-input form-control">
			<span class="field-name">Email: </span><input type="email" name="email" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" class="e-input form-control">
            <div class="gender-container">
                <span class="gender-title">Gender:</span>
                <input type="radio" name="gender" value="Male" class="e-input e-radio form-control"><span class="gender">Male</span>
                <input type="radio" name="gender" value="Female" class="e-input e-radio form-control"><span class="gender">Female</span>
            </div>
			<input type="submit" name="submit" value="Add Employee" class="e-btn btn btn-block btn-success">
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