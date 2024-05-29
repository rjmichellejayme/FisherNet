<?php
include "dbfish.php"; 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>User Registration</title>
</head>
<body>
    <header>
        <h1>User Registration</h1>
        <p>Welcome!</p>
    </header>
    <br>
    <nav class="navbar navbar-expand-lg bg-body-primary">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile_management.php">Profile Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="fishing_zone">Fishing Zones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catch_logbook.php">Catch Logbook</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="fish_market_prices.php">Fish Market Prices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="equipment">Equipment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="equipment_management">Equipment Management</a>
                </li>

              </ul>            
            </div>         
          </div>
      </nav>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>