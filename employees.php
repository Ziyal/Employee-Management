<?php
    //define page title
    $title = 'Employees - Employee Management';
    //include header template
    require('layout/header.php');
?>

<h1>All Employees</h1>

<?php require('config.php');
    // $sql = "SELECT * FROM employees ORDER BY hire_date";
    $stmt = $db->prepare('SELECT * FROM employees ORDER BY hire_date');
    $stmt->execute();
    $result = $stmt;

    if($result){
        echo "<div class='employee-container'>";
            echo "<table class='table table-hover'>";
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
            foreach($result as $row){
                echo "</tbody>";
                    echo "<tr>";
                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['birthday'] . "</td>";
                        echo "<td>" . $row['hire_date'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td><button value=". $row['employee_id'] . ">Edit</button></td>";
                        echo "<td><form action='delete_employee/" . $row['employee_id'] . "' method='post'><input type='submit' value='Delete'></form></td>";
                    echo "</tr>";
                echo "</tbody>";
            }
            echo "</table>";
        echo "</div>";
        // Free result set
        // mysqli_free_result($result);
    } else{
        echo "ERROR: Could not execute $sql. " . mysqli_error($db);
    }


    // if($result = mysqli_query($db, $sql)){
    //     if(mysqli_num_rows($result) > 0){
    //         echo "<table>";
    //             echo "<tr>";
    //                 echo "<th>Name</th>";
    //                 echo "<th>Gender</th>";
    //                 echo "<th>Birthday</th>";
    //                 echo "<th>Date of Hire</th>";
    //                 echo "<th>Email</th>";
    //             echo "</tr>";
    //         while($row = mysqli_fetch_array($result)){
    //             echo "<tr>";
    //                 echo "<td>" . $row['first_name'] . "</td>";
    //                 echo "<td>" . $row['gender'] . "</td>";
    //                 echo "<td>" . $row['birthday'] . "</td>";
    //                 echo "<td>" . $row['date_hired'] . "</td>";
    //                 echo "<td>" . $row['email'] . "</td>";
    //             echo "</tr>";
    //         }
    //         echo "</table>";
    //         // Free result set
    //         mysqli_free_result($result);
    //     } else{
    //         echo "No records matching your query were found.";
    //     }
    // } else{
    //     echo "ERROR: Could not execute $sql. " . mysqli_error($db);
    // }

?>


<?php
    //include footer template
    require('layout/footer.php');
?>