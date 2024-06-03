<?php
include 'dbfish.php';
session_start();
if(!empty($_SESSION["UserID"])){
    $userid = $_SESSION["UserID"];
} else {
    echo "<script> alert('Please log in first.'); window.location.href='login.php'; </script>";
    exit();
}

if(isset($_POST["submit"])){
    $zonename = $_POST['zoneName'];
    $desc = $_POST['zoneDescription'];
 
    $duplicate = mysqli_query($conn, "SELECT * FROM fishingzones WHERE zoneName = '$zonename'");
    if(mysqli_num_rows($duplicate) > 0){
        echo "<script> alert('Zone Already Existed'); </script>";
    } else {
        $query = "INSERT INTO fishingzones (zoneName, description, userID) VALUES ('$zonename', '$desc', '$userid')";
        mysqli_query($conn, $query);
        echo "<script> alert('Added Successfully'); </script>";
    }
}

$searchResult = null;
if(isset($_POST["search"])){
    $searchName = $_POST['searchName'];
    $searchQuery = "SELECT * FROM fishingzones WHERE zoneName = '$searchName'";
    $searchResult = mysqli_query($conn, $searchQuery);
    if(mysqli_num_rows($searchResult) == 0){
        echo "<script> alert('No Zone Found'); </script>";
    }
}

if(isset($_POST["delete"])){
    $zoneName = $_POST['deleteName'];
    $deleteLogbookQuery = "DELETE FROM CatchLogbook WHERE ZoneName = '$zoneName'";
    $deleteLogbookResult = mysqli_query($conn, $deleteLogbookQuery);

    if ($deleteLogbookResult) {
     $deleteZoneQuery = "DELETE FROM FishingZones WHERE ZoneName = '$zoneName' AND UserID = '$userid'";
        $deleteZoneResult = mysqli_query($conn, $deleteZoneQuery);

        if ($deleteZoneResult) {
            echo "<script> alert('Zone Deleted Successfully'); </script>";
        } else {
            echo "<script> alert('Error deleting zone: " . mysqli_error($conn) . "'); </script>";
        }
    } else {
        echo "<script> alert('Error deleting associated logbook entries: " . mysqli_error($conn) . "'); </script>";
    }
}

if (isset($_POST["update"])) {
    $zoneName = $_POST['updateName'];
    $newZoneName = $_POST['newZoneName'];
    $updateZoneQuery = "UPDATE FishingZones SET ZoneName = '$newZoneName' WHERE ZoneName = '$zoneName' ";
    $updateZoneResult = mysqli_query($conn, $updateZoneQuery);

    if ($updateZoneResult) {
        $updateLogbookQuery = "UPDATE CatchLogbook SET ZoneName = '$newZoneName' WHERE ZoneName = '$zoneName' AND UserID = '$userid'";
        $updateLogbookResult = mysqli_query($conn, $updateLogbookQuery);

        if ($updateLogbookResult) {
            echo "<script> alert('Zone Updated Successfully'); </script>";
        } else {
            echo "<script> alert('Error updating logbook: " . mysqli_error($conn) . "'); </script>";
        }
    } else {
        echo "<script> alert('Error updating zone: " . mysqli_error($conn) . "'); </script>";
    }
}




$userZones = [];
$userZonesQuery = "SELECT * FROM fishingzones WHERE userID = '$userid'";
$userZonesResult = mysqli_query($conn, $userZonesQuery);
if ($userZonesResult && mysqli_num_rows($userZonesResult) > 0) {
    while ($row = mysqli_fetch_assoc($userZonesResult)) {
        $userZones[] = $row;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
        function showForm(formId) {
            document.getElementById('zoneForm').style.display = 'none';
            document.getElementById('searchForm').style.display = 'none';
            document.getElementById('deleteForm').style.display = 'none';
            document.getElementById('updateForm').style.display = 'none';
            document.getElementById(formId).style.display = 'block';
        }
    </script>
    <style>
        .form-container {
            margin-top: 5%;
            display: none;
        }
    </style>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <nav class="navbar navbar-expand-lg bg-body-primary">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="index_fish.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="profileManagement.php">Profile Management</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="fishing_zone.php">Fishing Zones</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="catch_logbook.php">Catch Logbook</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="fish_market_prices.php">Fish Market Prices</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="equipment.php">Equipment</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="equipment_management.php">Equipment Management</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Log Out</a>
                </li>
              </ul>            
            </div>
            
          </div>
      </nav>
    <main>
        <h2>Manage Fishing Zones</h2>
        <br>
        <label for="actionSelect">Choose an action:</label>
            <select id="actionSelect" onchange="showForm(this.value)">
                <option value="">Select an action</option>
                <option value="zoneForm">Add Zone</option>
                <option value="searchForm">Search Zone</option>
                <option value="deleteForm">Delete Zone</option>
                <option value="updateForm">Update Zone</option>
            </select>


        <form id="zoneForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Add Zone</h2>
            <label for="zoneName">Zone Name:</label>
            <input type="text" id="zoneName" name="zoneName" required><br>
            <label for="zoneDescription">Zone Description:</label>
            <textarea id="zoneDescription" name="zoneDescription" required></textarea><br>
            <br>
            <button type="submit" name="submit" value="submit">Add Zone</button>
        </form>

        <form id="searchForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Search Zone</h2>
            <label for="searchName">Zone Name:</label>
            <input type="text" id="searchName" name="searchName" required><br>
            <button type="submit" name="search" value="search">Search</button>
        </form>
         <?php if ($searchResult && mysqli_num_rows($searchResult) > 0) { ?>
         <h3>Search Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Zone Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($entry = mysqli_fetch_assoc($searchResult)) { ?>
                    <tr>
                        <td><?php echo $entry['ZoneName']; ?></td>
                        <td><?php echo $entry['Description']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>

        <form id="deleteForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Delete Zone</h2>
            <label for="deleteName">Zone Name:</label>
            <select id="deleteName" name="deleteName" required>
                <option value="">Select Zone Name</option>
                <?php foreach ($userZones as $zone) { ?>
                    <option value="<?php echo $zone['ZoneName']; ?>"><?php echo $zone['ZoneName']; ?></option>
                <?php } ?>
            </select><br>
            <button type="submit" name="delete" value="delete">Delete</button>
        </form>


        <form id="updateForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Update Zone</h2>
            <label for="updateName">Current Zone Name:</label>
            <select id="updateName" name="updateName" required>
                <option value="">Select Zone Name</option>
                <?php foreach ($userZones as $zone) { ?>
                    <option value="<?php echo $zone['ZoneName']; ?>"><?php echo $zone['ZoneName']; ?></option>
                <?php } ?>
            </select><br>

            <label for="newZoneName">New Zone Name:</label>
            <input type="text" id="newZoneName" name="newZoneName" required><br>

            <label for="newDescription">New Description:</label>
            <textarea id="newDescription" name="newDescription" required></textarea><br>
            <br>
            <button type="submit" name="update" value="update">Update Zone</button>
        </form>

        <h2>Your Fishing Zones</h2>
        <?php
        if (!empty($userZones)) {
            echo "<table>";
            echo "<tr><th>Zone Name</th><th>Description</th></tr>";
            foreach ($userZones as $zone) {
                echo "<tr>";
                echo "<td>" . $zone['ZoneName'] . "</td>";
                echo "<td>" . $zone['Description'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No zones added yet.</p>";
        }
        ?>
        
    </main>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
