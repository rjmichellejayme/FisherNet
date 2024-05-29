<?php
require 'dbfish.php';
session_start();

if (!empty($_SESSION["UserID"])) {
    $userid = $_SESSION["UserID"];
}

if (isset($_POST["submit"])) {
    $selectedEquipment = $_POST['equipmentSelect'];
    $eqname = $selectedEquipment === 'others' ? $_POST['equipmentName'] : $selectedEquipment;
    $quantity = $_POST['quantity'];
    $duplicate = mysqli_query($conn, "SELECT * FROM equipment WHERE EquipName = '$eqname'");

    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script> alert('Equipment Already Exists'); </script>";
    } else {
        $query = "INSERT INTO equipment (equipname, quantity, userid) VALUES ('$eqname', '$quantity', '$userid')";
    mysqli_query($conn, $query);
    echo "<script> alert('Equipment Added'); </script>";
    }
}

if (isset($_POST["edit"])) {
    $eqname = $_POST['editEquipmentName'];
    $newQuantity = $_POST['newQuantity'];
    $updateQuery = "UPDATE equipment SET quantity='$newQuantity' WHERE equipname='$eqname' AND userid='$userid'";
    $updateResult = mysqli_query($conn, $updateQuery);
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Equipmet Updated Successfully'); </script>";
    } else {
        echo "<script> alert('No Equipment Found to Update'); </script>";
    }
}


if (isset($_POST["delete"])) {
    $deleteName = $_POST['deleteName'];
    $deleteQuery = "DELETE FROM equipment WHERE equipname = '$deleteName' AND userid='$userid'";
    $deleteResult = mysqli_query($conn, $deleteQuery);
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Equipment Deleted Successfully'); </script>";
    } else {
        echo "<script> alert('No Equipment Found to Delete'); </script>";
    }
}

$userZones = [];
$userZonesQuery = "SELECT * FROM equipment WHERE userID = '$userid'";
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
    <title>Equipment Management</title>
    <link rel="stylesheet" href="stylefish.css">
    <script>
        function handleEquipmentChange() {
            const equipmentSelect = document.getElementById('equipmentSelect');
            const equipmentNameInput = document.getElementById('equipmentName');

            if (equipmentSelect.value === 'others') {
                equipmentNameInput.required = true;
                equipmentNameInput.disabled = false;
            } else {
                equipmentNameInput.required = false;
                equipmentNameInput.disabled = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const equipmentSelect = document.getElementById('equipmentSelect');
            equipmentSelect.addEventListener('change', handleEquipmentChange);
            handleEquipmentChange(); 
        });

        function showForm(formId) {
            const forms = document.querySelectorAll('.equipment-form');
            forms.forEach(form => form.style.display = 'none');
            document.getElementById(formId).style.display = 'block';
        }
    </script>
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
        <h2>Equipments</h2>

         <label for="actionSelect">Choose an action:</label>
        <select id="actionSelect" onchange="showForm(this.value)">
            <option value="">Select an action</option>
            <option value="equipmentForm">Add Equipment</option>
            <option value="deleteForm">Delete Equipment</option>
            <option value="editQuantityForm">Update Equipment</option>
        </select>

        <form id="equipmentForm" class="equipment-form" action="" method="post">
            <label for="equipmentSelect">Equipment Name:</label>
            <select id="equipmentSelect" name="equipmentSelect" required>
                <option value="lines">Lines</option>
                <option value="nets">Nets</option>
                <option value="fishscale">Fish scale</option>
                <option value="fishingboat">Fishing Boat</option>
                <option value="rudder">Rudder</option>
                <option value="engine">Engine</option>
                <option value="float">Floats</option>
                <option value="others">Others</option>
            </select><br>
            
            <label for="equipmentName">Specify if Others:</label>
            <input type="text" id="equipmentName" name="equipmentName" disabled><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br><br>
             <button type="submit" name="submit" value="submit">Submit</button>
        </form>

      
        <form id="editQuantityForm" class="equipment-form" style="display: none;" action="" method="post">
            <label for="editEquipmentName">Equipment Name:</label>

            <input type="text" id="editEquipmentName" name="editEquipmentName" required><br>
            <label for="newQuantity">New Quantity:</label>

            <input type="number" id="newQuantity" name="newQuantity" required><br><br>
             <button type="submit" name="edit" value="edit">Submit</button>
        </form>

        <form id="deleteForm" class="equipment-form" style="display: none;" action="" method="post">
            <label for="deleteName">Equipment Name:</label>
            <input type="text" id="deleteName" name="deleteName" required><br><br>
             <button type="submit" name="delete" value="delete">Submit</button>
        </form>
        <h2>Your Equipments</h2>
        <?php
        if (!empty($userZones)) {
            echo "<table>";
            echo "<tr><th>Zone Name</th><th>Description</th></tr>";
            foreach ($userZones as $zone) {
                echo "<tr>";
                echo "<td>" . $zone['EquipName'] . "</td>";
                echo "<td>" . $zone['Quantity'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No zones added yet.</p>";
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

