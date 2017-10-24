<?php require('config.php');
//logout with method in user.php
$user->logout(); 

//redirect to index
header('Location: index.php');
exit;
?>