<?php
require 'dbfish.php';
session_start();

if(!empty($_SESSION["UserID"])){
    header("location:index_fish.php");
}

if(isset($_POST["submit"])){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $userType = $_POST['userType'];
    $duplicate = mysqli_query($conn, "SELECT * from users where Username = '$name' OR email = '$email'");
if(mysqli_num_rows($duplicate)>0){
    echo "<script> alert('username or Email is Already Taken'); </script>";

}else{
    if($password == $confirmpassword){
        $query = "INSERT into users (username, email, password, confirmpassword, usertype) VALUES ('$name', '$email','$password','$confirmpassword', '$userType')";
        mysqli_query($conn, $query);
        echo "<script> alert('Registration Successful'); </script>";

    }else{
        echo "<script> alert('Password Does not Match'); </script>";

    }
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylefish.css">
    <title>User Registration</title>
</head>
<body>
    <header>
        <h1>User Registration</h1>
    </header>
    <br>
    <main>
        <form class="" action="" method="post" autocomplete="off">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required value=""><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="confirmpassword">Confirm Password:</label>
            <input type="password" id="confirmpassword" name="confirmpassword" required><br>
            
            <label for="userType">User Type:</label>
            <select id="userType" name="userType" required>
                <option value="Fisherman">Fisherman</option>
            </select><br>
            
            <input type="submit" name="submit" value="Register">
        </form>
    </main>
    
    <nav id=back>
        <a href="index_fish.php">Home</a>
        <a href="login.php">Login</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>