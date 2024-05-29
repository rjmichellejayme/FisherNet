<?php
require 'dbfish.php';
session_start();
if(!empty($_SESSION["UserID"])){
    $userid = $_SESSION["UserID"];
}
if(isset($_POST["submit"])){
    $zonename = $_POST['zoneName'];
    $desc = $_POST['zoneDescription'];
    $long = $_POST['longitude'];
    $lat =  $_POST['latitude'];
    $duplicate = mysqli_query($conn, "SELECT * from fishingzones where zoneName = '$zonename'");
if(mysqli_num_rows($duplicate)>0){
    echo "<script> alert('Zone Already Existed'); </script>";

}else{
        $query = "INSERT into fishingzones (zonename, latitude, longitude, description, userid) VALUES ('$zonename','$long','$lat','$desc', '$userid')";
        mysqli_query($conn, $query);
        echo "<script> alert('Added Successfully'); </script>";
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fishing Zones</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Fishing Zones</h2>
        <form id="zoneForm" class="" action="" method="post" autocomplete="off">
            <label for="zoneName">Zone Name:</label>
            <input type="text" id="zoneName" name="zoneName" required><br>

            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" required><br>

            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" required><br>

            <label for="zoneDescription">Zone Description:</label>
            <textarea id="zoneDescription" name="zoneDescription" required></textarea><br>
            <button type="submit" name="submit" value="submit" >Add Zone</button>
        </form>
    </main>
    <nav id=back><br>
        <a href="index_fish.php">Home</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
