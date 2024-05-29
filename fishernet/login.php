<?php
require 'dbfish.php';
session_start();

if(!empty($_SESSION["UserID"])){
    header("location:index_fish.php");
}

if(isset($_POST["submit"])){
    $name = $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * from users where username = '$name' OR email = '$name'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result)>0){
        if($password == $row["Password"]){
            $_SESSION["login"] = true;
            $_SESSION["UserID"] = $row["UserID"];
            header("location: index_fish.php");

        }else{
            echo "<script> alert('Wrong Password'); </script>";
        }   
    }else{
    echo "<script> alert('User Not Registered'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>User Log-in</h1>
    </header>
    <br>
    <main>
    <form action="" method="post" autocomplete="off">
            <label for="username">Username or Email:</label>
            <input type="text" id="username" name="username" required><br>       
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" name="submit" value="Log-in">
    </form>
    </main>
    
    <nav id=back>
        <a href="index_fish.php">Home</a>
        <a href="profile.php">Register</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>