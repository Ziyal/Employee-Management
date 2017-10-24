
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="style/main.css">
    </head>

    <body>
        <div class="navbar-container">
            <ul>
                <li>
                    <span class="title">Employee Management</span>
                </li>

                <li>
                    <a href="employees.php">Employees</a>
                </li>

                <li>
                    <a href="register.php">Add Admin</a>
                </li>

                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>

            <p>Hello, <?php echo htmlspecialchars($_SESSION['email']); ?></p>

        </div>