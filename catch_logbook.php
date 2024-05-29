<?php
include "dbfish.php"; 
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
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

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->

</body>
</html>
