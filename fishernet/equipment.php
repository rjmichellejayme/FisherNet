<?php
include 'dbfish.php';
session_start();

$userid = null;

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
        $query = "INSERT INTO equipment (EquipName, quantity, userid) VALUES ('$eqname', '$quantity', '$userid')";
    mysqli_query($conn, $query);
    echo "<script> alert('Equipment Added'); </script>";
    }
}

if (isset($_POST["edit"])) {
    $eqname = $_POST['editEquipmentName'];
    $newQuantity = $_POST['newQuantity'];
    $updateQuery = "UPDATE equipment SET quantity='$newQuantity' WHERE EquipName='$eqname' AND userid='$userid'";
    $updateResult = mysqli_query($conn, $updateQuery);
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Equipment Updated Successfully'); </script>";
    } else {
        echo "<script> alert('No Equipment Found to Update'); </script>";
    }
}


if (isset($_POST["delete"])) {
    $deleteName = $_POST['deleteName'];
    $deleteQuery = "DELETE FROM equipment WHERE EquipName = '$deleteName' AND userid='$userid'";
    $deleteResult = mysqli_query($conn, $deleteQuery);
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Equipment Deleted Successfully'); </script>";
    } else {
        echo "<script> alert('No Equipment Found to Delete'); </script>";
    }
}

$userEquipment = [];
$userEquipmentQuery = "SELECT * FROM equipment WHERE userID = '$userid'";
$userEquipmentResult = mysqli_query($conn, $userEquipmentQuery);
if ($userEquipmentResult && mysqli_num_rows($userEquipmentResult) > 0) {
    while ($row = mysqli_fetch_assoc($userEquipmentResult)) {
        $userEquipment[] = $row;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h2>Equipments</h2>
            <label for="actionSelect">Choose an action:</label>
            <select id="actionSelect" onchange="showForm(this.value)" class="form-select">
                <option value="">Select an action</option>
                <option value="equipmentForm">Add Equipment</option>
                <option value="deleteForm">Delete Equipment</option>
                <option value="editQuantityForm">Update Equipment</option>
            </select>

        <form id="equipmentForm" class="equipment-form form-container" action="" method="post">
            <h2>Log Equipment Details</h2>
            <br>
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

      
        <form id="editQuantityForm" class="equipment-form form-container" style="display: none;" action="" method="post">
            <h2>Update Equipment Details</h2>
            <br>
            <label for="editEquipmentName">Equipment Name:</label>
            <select id="editEquipmentName" name="editEquipmentName" required>
                <option value="">Select Equipment</option>
                <?php foreach ($userEquipment as $equipment): ?>
                    <option value="<?php echo $equipment['EquipName']; ?>"><?php echo $equipment['EquipName']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <label for="newQuantity">New Quantity:</label>

            <input type="number" id="newQuantity" name="newQuantity" required><br><br>
             <button type="submit" name="edit" value="edit">Submit</button>
        </form>

        <form id="deleteForm" class="equipment-form form-container" style="display: none;" action="" method="post">
            <h2>Delete Equipment</h2>
            <br>
            <label for="deleteName">Equipment Name:</label>
            <select id="deleteName" name="deleteName" required>
                <?php foreach ($userEquipment as $equipment): ?>
                    <option value="<?php echo $equipment['EquipName']; ?>"><?php echo $equipment['EquipName']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
             <button type="submit" name="delete" value="delete">Submit</button>
        </form>
        
        <h2>Your Equipments</h2>
        <?php
        if (!empty($userEquipment)) {
            echo "<table>";
            echo "<tr><th>Equipment Name</th><th>Quantity</th></tr>";
            foreach ($userEquipment as $zone) {
                echo "<tr>";
                echo "<td>" . $zone['EquipName'] . "</td>";
                echo "<td>" . $zone['Quantity'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No equipment is added yet.</p>";
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

