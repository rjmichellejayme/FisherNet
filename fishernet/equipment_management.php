<?php
require 'dbfish.php';
session_start();

if (!empty($_SESSION["UserID"])) {
    $userid = $_SESSION["UserID"];
}

$equipmentQuery = "SELECT EquipID, EquipName FROM Equipment WHERE UserID = '$userid'";
$equipmentResult = mysqli_query($conn, $equipmentQuery);

if (isset($_POST["submit"])) {
    $equipmentID = $_POST['equipmentID'];
    $maintenanceType = $_POST['maintenanceType'];
    $description = $_POST['maintenanceNotes'];
    $maintenanceDate = $_POST['maintenanceDate'];
    $maintenanceCost = $_POST['maintenanceCost'];

    $query = "INSERT INTO MaintenanceLog (EquipID, MaintenanceDate, MaintenanceType, Cost, Notes) VALUES ('$equipmentID', '$maintenanceDate', '$maintenanceType', '$maintenanceCost', '$description')";
    if (mysqli_query($conn, $query)) {
        echo "<script> alert('Maintenance Record Added'); </script>";
    } else {
        echo "<script> alert('Error: " . mysqli_error($conn) . "'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Management</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Maintenance Log</h2>
        <form id="maintenanceForm" method="post" autocomplete="off">
            <label for="equipmentID">Equipment:</label>
            <select id="equipmentID" name="equipmentID" required>
                <?php while ($row = mysqli_fetch_assoc($equipmentResult)) { ?>
                    <option value="<?php echo $row['EquipID']; ?>"><?php echo $row['EquipName']; ?></option>
                <?php } ?>
            </select><br>

            <label for="maintenanceType">Maintenance Type:</label>
            <input type="text" id="maintenanceType" name="maintenanceType" required><br>

            <label for="maintenanceDate">Maintenance Date:</label>
            <input type="date" id="maintenanceDate" name="maintenanceDate" required><br>

            <label for="maintenanceCost">Maintenance Cost:</label>
            <input type="number" id="maintenanceCost" name="maintenanceCost" step="0.01" required><br>

            <label for="maintenanceNotes">Maintenance Notes:</label>
            <textarea id="maintenanceNotes" name="maintenanceNotes"></textarea><br><br>

            <button type="submit" name="submit">Add Maintenance</button>
        </form>
    </main>
    <nav id="back">
        <a href="index_fish.php">Home</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
