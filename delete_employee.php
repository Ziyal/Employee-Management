<?php
    //define page title
    $title = 'Employees - Employee Management';
    //include header template
    require('layout/header.php');

    require 'config.php';

        $employee_id = 0;
        
        // When confirm delete page is loaded
        if (!empty($_GET['employee_id'])) {
            $employee_id = $_REQUEST['employee_id'];
        }
        
        // When red delete button is clicked
        if (!empty($_POST)) {
            // keep track employee_id
            $employee_id = $_POST['employee_id'];
            
            // delete employee
            $stmt = $db->prepare('DELETE FROM employees WHERE employee_id = ' . $employee_id . '');
            $stmt->execute();
            $result = $stmt;
            header("Location: employees.php");
        }
?>

<div class="container">
    <h1>Delete Employee</h1>
    <form action="delete_employee.php" method="post">
        <input type="hidden" name="employee_id" value="<?php echo $employee_id;?>"/>
        <p>Are you sure you want to delete <?php echo $employee_id;?></p>
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Yes</button>
            <a class="btn" href="employees.php">No</a>
        </div>
    </form>
</div>

<?php
    //include footer template
    require('layout/footer.php');
?>