<?php
include 'dbfish.php';
session_start();

if (!empty($_SESSION["UserID"])) {
    header("location:index_fish.php");
}

if (isset($_POST["submit"])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE Username = '$name' OR email = '$email'");
    
    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script> alert('Username or Email is Already Taken'); </script>";
    } else {
            $query = "INSERT INTO users (username, email, password, usertype) VALUES ('$name', '$email', '$password', '$userType')";
            mysqli_query($conn, $query);
            echo "<script> alert('Registration Successful'); </script>";
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
        <form action="" method="post" autocomplete="off">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required value=""><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <label for="userType">User Type:</label>
            <select id="userType" name="userType" required>
                <option value="Fisherman">Fisherman</option>
            </select><br>
            
            <input type="submit" name="submit" value="Register">
            <br>
        <p>Already have an account? <a href="login.php">Log in</a></p>

        </form>
        
    </main>
    
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
