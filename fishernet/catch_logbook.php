<?php
require 'dbfish.php';
session_start();

if(!empty($_SESSION["UserID"])){
    $userid = $_SESSION["UserID"];
}

if(isset($_POST["submit"])){
    $zoneid = $_POST['zoneid'];
    $species = $_POST['species'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $datetime = $date . ' ' . $time;
    $zone_check = mysqli_query($conn, "SELECT * FROM fishingzones WHERE ZoneID = '$zoneid'");
    if (mysqli_num_rows($zone_check) == 0) {
        echo "<script> alert('Invalid Zone ID'); </script>";
    }else{
        $query = "INSERT into catchlogbook (zoneid, species, quantity, datetime, userid) VALUES ('$zoneid', '$species','$quantity','$datetime', '$userid')";
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
    <title>Catch Logbook</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Catch Logbook</h2>
        
        <form id="logbookForm" action="" method="post" autocomplete="off">
            <label for="zoneid">Zone ID:</label>
            <input type="number" id="zoneid" name="zoneid" required><br>
            <label for="species">Species:</label>
            <input type="text" id="species" name="species" required><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required><br>
            <button type="submit" name="submit">Add Entry</button>
        </form>
    </main>
    <nav id=back>
        <a href="index_fish.php">Home</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>

</body>
</html>
