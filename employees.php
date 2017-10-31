<?php
    //define page title
    $title = 'Employees - Employee Management';
    //include header template
    require('layout/header.php');
?>
<div class='container'>
    <div class="employees-top-container">
        <h1 class="employee-title">All Employees</h1>
        <a href="employee_add.php" class="new-employee-btn"><button class="btn btn-success btn-lg">New Employee</button></a>
    </div>

    <?php require('config.php');
        $stmt = $db->prepare('SELECT * FROM employees ORDER BY hire_date');
        $stmt->execute();
        $result = $stmt;

        if($result){
                echo "<table class='table table-striped table-condensed'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Name</th>";
                            echo "<th>Gender</th>";
                            echo "<th>Birthday</th>";
                            echo "<th>Date of Hire</th>";
                            echo "<th>Email</th>";
                            echo "<th>Edit</th>";
                            echo "<th>Delete</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                foreach($result as $row){
                        echo "<tr>";
                            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                            echo "<td>" . $row['gender'] . "</td>";
                            echo "<td>" . $row['birthday'] . "</td>";
                            echo "<td>" . $row['hire_date'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td><button value=". $row['employee_id'] . " class='btn btn-primary btn-sm'>Edit</button></td>";
                            echo "<td><form action='delete_employee/" . $row['employee_id'] . "' method='post'><input type='submit' value='Delete' class='btn btn-danger btn-sm'></form></td>";
                        echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
        } else {
            echo "ERROR: Could not execute $sql. " . mysqli_error($db);
        }
    ?>

</div>

<?php
    //include footer template
    require('layout/footer.php');
?>