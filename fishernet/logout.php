<?php
require 'dbfish.php';
session_start();

$_SESSION = [];
session_unset();
session_destroy();
header("Location:Login.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    
</body>
</html>