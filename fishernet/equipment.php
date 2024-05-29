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
    $duplicate = mysqli_query($conn, "SELECT * from equipment where EquipName = '$eqname'");

    if(mysqli_num_rows($duplicate)>0){
        echo "<script> alert('Equipment Already Existed'); </script>";
    }else{
    $query = "INSERT INTO equipment (equipname, quantity, userid) VALUES ('$eqname', '$quantity', '$userid')";
    mysqli_query($conn, $query);
    echo "<script> alert('Equipment Added'); </script>";
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
            handleEquipmentChange(); // Set the initial state based on the default selection
        });
    </script>
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Equipments</h2>

        <form id="equipmentForm" action="" method="post">
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
            
            <button type="submit" name="submit">Add Equipment</button>
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
