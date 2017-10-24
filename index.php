    
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
        </div>
    </body>

</html>

    <?php
        //include footer template
        require('layout/footer.php');
    ?>