<?php
require 'dbfish.php';
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
    $deleteName = $_POST['deleteName'];
    $deleteQuery = "DELETE FROM fishingzones WHERE zoneName = '$deleteName'";
    $deleteResult = mysqli_query($conn, $deleteQuery);
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Zone Deleted Successfully'); </script>";
    } else {
        echo "<script> alert('No Zone Found to Delete'); </script>";
    }
}

if(isset($_POST["update"])){
    $updateName = $_POST['updateName'];
    $newZoneName = $_POST['newZoneName'];
    $newDescription = $_POST['newDescription'];
    $updateQuery = "UPDATE fishingzones SET zoneName='$newZoneName', description='$newDescription' WHERE zoneName='$updateName' AND userID='$userid'";
    $updateResult = mysqli_query($conn, $updateQuery);
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Zone Updated Successfully'); </script>";
    } else {
        echo "<script> alert('No Zone Found to Update'); </script>";
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
    <main>
        <h2>Manage Fishing Zones</h2>
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
            <button type="submit" name="submit" value="submit">Add Zone</button>
        </form>

        <form id="searchForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Search Zone</h2>
            <label for="searchName">Zone Name:</label>
            <input type="text" id="searchName" name="searchName" required><br>
            <button type="submit" name="search" value="search">Search</button>
        </form>

        <?php
        if($searchResult && mysqli_num_rows($searchResult) > 0){
            $row = mysqli_fetch_assoc($searchResult);
            echo "<h3>Zone Details</h3>";
            echo "<p>Zone Name: " . $row['ZoneName'] . "</p>";
            echo "<p>Description: " . $row['Description'] . "</p>";
        }
        ?>

        <form id="deleteForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Delete Zone</h2>
            <label for="deleteName">Zone Name:</label>
            <input type="text" id="deleteName" name="deleteName" required><br>
            <button type="submit" name="delete" value="delete">Delete</button>
        </form>

        <form id="updateForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Update Zone</h2>
            <label for="updateName">Current Zone Name:</label>
            <input type="text" id="updateName" name="updateName" required><br>

            <label for="newZoneName">New Zone Name:</label>
            <input type="text" id="newZoneName" name="newZoneName" required><br>

            <label for="newDescription">New Description:</label>
            <textarea id="newDescription" name="newDescription" required></textarea><br>
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
    <nav id="back"><br>
        <a href="index_fish.php">Home</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
