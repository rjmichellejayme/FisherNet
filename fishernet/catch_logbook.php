<?php
include 'dbfish.php';
session_start();

if (!empty($_SESSION["UserID"])) {
    $userid = $_SESSION["UserID"];
}

// Adding Entry
if (isset($_POST["submit"])) {
    $zonename = $_POST['zonename'];
    $species = $_POST['species'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $datetime = $date . ' ' . $time;
    $zone_check = mysqli_query($conn, "SELECT * FROM fishingzones WHERE ZoneName = '$zonename'");
    if (mysqli_num_rows($zone_check) == 0) {
        echo "<script> alert('Invalid Zone Name'); </script>";
    } else {
        $query = "INSERT into catchlogbook (ZoneName, Species, Quantity, DateTime, UserID) VALUES ('$zonename', '$species','$quantity','$datetime', '$userid')";
        mysqli_query($conn, $query);
        echo "<script> alert('Added Successfully'); </script>";
    }
}

// Deleting Entry
if (isset($_POST["delete"])) {
    $logID = $_POST['deleteName'];
    $deleteQuery = "DELETE FROM catchlogbook WHERE ZoneName = '$logID' AND UserID = '$userid'";
    mysqli_query($conn, $deleteQuery);
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> alert('Entry Deleted Successfully'); </script>";
    } else {
        echo "<script> alert('No Entry Found to Delete'); </script>";
    }
}

// Updating Entry
if (isset($_POST["update"])) {
    $logID = $_POST['zonename'];
    $newSpecies = $_POST['newSpecies'];
    $newQuantity = $_POST['newQuantity'];
    $newDate = $_POST['newDate'];
    $newTime = $_POST['newTime'];
    $newDateTime = $newDate . ' ' . $newTime;
    $updateQuery = "UPDATE catchlogbook SET Species='$newSpecies', Quantity='$newQuantity', DateTime='$newDateTime' WHERE ZoneName='$logID' AND UserID='$userid'";
    mysqli_query($conn, $updateQuery);
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> alert('Entry Updated Successfully'); </script>";
    } else {
        echo "<script> alert('No Entry Found to Update'); </script>";
    }
}

// Fetching Logbook Entries
$logbookEntries = [];
$logbookQuery = "SELECT * FROM catchlogbook WHERE UserID = '$userid'";
$logbookResult = mysqli_query($conn, $logbookQuery);
if ($logbookResult && mysqli_num_rows($logbookResult) > 0) {
    while ($row = mysqli_fetch_assoc($logbookResult)) {
        $logbookEntries[] = $row;
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
    <script>
        function showForm(formId) {
            var forms = document.getElementsByClassName('form-container');
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = 'none';
            }
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
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Catch Logbook</h2>
        <label for="actionSelect">Choose an action:</label>
        <select id="actionSelect" onchange="showForm(this.value)">
            <option value="">Select an action</option>
            <option value="zoneForm">Add Entry</option>
            <option value="deleteForm">Delete Entry</option>
            <option value="updateForm">Update Entry</option>
        </select>

        <!-- Add Entry Form -->
        <form id="zoneForm" class="form-container" action="" method="post" autocomplete="off">
            <label for="zonename">Zone Name:</label>
            <input type="text" id="zonename" name="zonename" required><br>
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

        <!-- Delete Entry Form -->
        <form id="deleteForm" class="form-container" action="" method="post" autocomplete="off">
          <h2>Delete</h2>
            <label for="deleteName">Zone Name:</label>
            <input type="text" id="deleteName" name="deleteName" required><br>
            <button type="submit" name="delete" value="delete">Delete</button>
       
        </form>
        <form id="updateForm" class="form-container" action="" method="post" autocomplete="off">
            <h2>Update Entry</h2>
          <label for="zonename">Zone Name:</label>
            <input type="text" id="zonename" name="zonename" required><br>
            <label for="newSpecies">New Species:</label>
            <input type="text" id="newSpecies" name="newSpecies" required><br>
            <label for="newQuantity">New Quantity:</label>
            <input type="number" id="newQuantity" name="newQuantity" required><br>
            <label for="newDate">New Date:</label>
            <input type="date" id="newDate" name="newDate" required><br>
            <label for="newTime">New Time:</label>
            <input type="time" id="newTime" name="newTime" required><br>
            <button type="submit" name="update">Update Entry</button>
        </form>

        </form>

        <!-- Logbook Entries Table -->
        <h2>Logbook Entries</h2>
        <?php
        if (!empty($logbookEntries)) {
            echo "<table>";
            echo "<tr><th>Log ID</th><th>Zone Name</th><th>Species</th><th>Quantity</th><th>Date & Time</th></tr>";
            foreach ($logbookEntries as $entry) {
                echo "<tr>";
                echo "<td>" . $entry['LogID'] . "</td>";
                echo "<td>" . $entry['ZoneName'] . "</td>";
                echo "<td>" . $entry['Species'] . "</td>";
                echo "<td>" . $entry['Quantity'] . "</td>";
                echo "<td>" . $entry['DateTime'] . "</td>";               
                echo "</form>";
            }
            echo "</table>";
        } else {
            echo "<p>No entries yet.</p>";
        }
        ?>
    </main>
    <nav id="back">
        <a href="index_fish.php">Home</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
