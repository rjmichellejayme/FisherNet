<?php
include 'dbfish.php';
session_start();

$userid = null;

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

    $duplicate = mysqli_query($conn, "SELECT * FROM maintenancelog WHERE EquipID = '$equipmentID'");
    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script> alert('Maintenance Already Exists'); </script>";
    } else {
        $query = "INSERT INTO maintenancelog (EquipID, MaintenanceDate, MaintenanceType, Cost, Notes) VALUES ('$equipmentID', '$maintenanceDate', '$maintenanceType', '$maintenanceCost', '$description')";
        if (mysqli_query($conn, $query)) {
            echo "<script> alert('Added Successfully'); </script>";
        } else {
            echo "<script> alert('Error: " . mysqli_error($conn) . "'); </script>";
        }
    }
}

$searchResult = null;
if (isset($_POST["search"])) {
    $searchName = $_POST['searchName'];
    $searchQuery = "SELECT * FROM maintenancelog WHERE EquipID IN (SELECT EquipID FROM Equipment WHERE EquipName = '$searchName' AND UserID = '$userid')";
    $searchResult = mysqli_query($conn, $searchQuery);
    if (mysqli_num_rows($searchResult) == 0) {
        echo "<script> alert('No Maintenance Found'); </script>";
    }
}
if (isset($_POST["update"])) {
    $updateEquipID = $_POST['updateEquipID'];
    $updateNotes = $_POST['updateNotes'];

    $updateQuery = "UPDATE maintenancelog SET Notes = '$updateNotes' WHERE EquipID = '$updateEquipID'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script> alert('Notes Updated Successfully'); </script>";
    } else {
        echo "<script> alert('Error updating notes: " . mysqli_error($conn) . "'); </script>";
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
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Maintenance Log</h2>
        <label for="actionSelect">Choose an action:</label>
        <select id="actionSelect" onchange="showForm(this.value)">
            <option value="">Select an action</option>
            <option value="maintenanceForm">Add Maintenance</option>
            <option value="searchForm">Search Equipment</option>
            <option value="updateForm">Maintenance Update</option>
        </select>

        <form id="maintenanceForm" class="form-container" method="post" autocomplete="off">
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
            <form id="searchForm" class="form-container" method="post" autocomplete="off">
                <h2>Search Equipment Maintenance</h2>
                <label for="searchName">Equipment Name:</label>
                <input type="text" id="searchName" name="searchName" required><br>
                <button type="submit" name="search">Search</button>
            </form>
            <form id="updateForm" class="form-container" method="post" autocomplete="off">
                <h2>Update Maintenance Notes</h2>
                <label for="updateEquipID">Equipment ID:</label>
                <input type="text" id="updateEquipID" name="updateEquipID" required><br>
                <label for="updateNotes">New Notes:</label>
                <textarea id="updateNotes" name="updateNotes" required></textarea><br>
                <button type="submit" name="update">Update Notes</button>
            </form>

<?php
if (!empty($searchResult)) {
    echo "<table>";
    echo "<tr><th>Equipment ID</th><th>Equipment Name</th><th>Maintenance Date</th><th>Maintenance Type</th><th>Cost</th><th>Notes</th></tr>";
    while ($maintenance = mysqli_fetch_assoc($searchResult)) {
        $equipID = $maintenance['EquipID'];
        $equipNameQuery = "SELECT EquipName FROM Equipment WHERE EquipID = '$equipID'";
        $equipNameResult = mysqli_query($conn, $equipNameQuery);
        $equipName = mysqli_fetch_assoc($equipNameResult)['EquipName'];

        echo "<tr>";
        echo "<td>" . $maintenance['EquipID']  . "</td>";
        echo "<td>" . $equipName . "</td>";
        echo "<td>" . $maintenance['MaintenanceDate'] . "</td>";
        echo "<td>" . $maintenance['MaintenanceType'] . "</td>";
        echo "<td>" . $maintenance['Cost'] . "</td>";
        echo "<td>" . $maintenance['Notes'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} 
?>
<h3>Your Equipment Maintenance</h3>
<table>
    <thead>
        <tr>
            <th>Equipment ID</th>
            <th>Equipment Name</th>
            <th>Maintenance Date</th>
            <th>Maintenance Type</th>
            <th>Cost</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $userMaintenanceQuery = "SELECT * FROM maintenancelog WHERE EquipID IN (SELECT EquipID FROM Equipment WHERE UserID = '$userid')";
        $userMaintenanceResult = mysqli_query($conn, $userMaintenanceQuery);
        while ($maintenanceEntry = mysqli_fetch_assoc($userMaintenanceResult)) {
            $equipID = $maintenanceEntry['EquipID'];
            $equipNameQuery = "SELECT EquipName FROM Equipment WHERE EquipID = '$equipID'";
            $equipNameResult = mysqli_query($conn, $equipNameQuery);
            $equipName = mysqli_fetch_assoc($equipNameResult)['EquipName'];

            echo "<tr>";
            echo "<td>" . $maintenanceEntry['EquipID']  . "</td>";
            echo "<td>" . $equipName . "</td>";
            echo "<td>" . $maintenanceEntry['MaintenanceDate'] . "</td>";
            echo "<td>" . $maintenanceEntry['MaintenanceType'] . "</td>";
            echo "<td>" . $maintenanceEntry['Cost'] . "</td>";
            echo "<td>" . $maintenanceEntry['Notes'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</main>
<nav id="back">
    <a href="index_fish.php">Home</a>
</nav>
<footer>
    <p>&copy; 2024 Fisherman Website</p>
</footer>
</body>
</html>

       
