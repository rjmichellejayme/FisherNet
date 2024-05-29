<?php
require 'dbfish.php';
session_start();

if(!empty($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
    $result = mysqli_query($conn, "SELECT * FROM users where UserID = '$UserID'");
    $row = mysqli_fetch_assoc($result);

}else{
   header("Location:profile.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisherman Website</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="fishing_zone.php">Fishing Zones</a></li>
                <li><a href="catch_logbook.php">Catch Logbook</a></li>
                <li><a href="fish_market_prices.php">Fish Market Prices</a></li>
                <li><a href="equipment.php">Equipment</a></li>
                <li><a href="equipment_management.php">Equipment Management</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
       <h1 id="welcome"> Welcome <?php echo $row["Username"]; ?> !!</h1><br>
    </main>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
