<?php
include 'dbfish.php';
session_start();

if (!empty($_SESSION["UserID"])) {
    $userid = $_SESSION["UserID"];
} else {
    echo "<script> alert('Please log in first.'); window.location.href='login.php'; </script>";
    exit();
}

// Form Submission Handling
if (isset($_POST["submit"])) {
    $price = $_POST['marketPrice'];
    $species = $_POST['species'];
    $action = $_POST['action'];

    if ($action === 'add') {
        $duplicate = mysqli_query($conn, "SELECT * FROM FishMarketPrices WHERE species = '$species'");
        if (mysqli_num_rows($duplicate) > 0) {
            echo "<script> alert('Species Already Exists'); </script>";
        } else {
            $query = "INSERT INTO FishMarketPrices (species, MarketPrice, pricedate, userID) VALUES ('$species', '$price', NOW(), '$userid')";
            mysqli_query($conn, $query);
            echo "<script> alert('Added Successfully'); </script>";
        }
    } elseif ($action === 'update') {
        $updateQuery = "UPDATE FishMarketPrices SET MarketPrice='$price' WHERE species='$species' AND userID='$userid'";
        mysqli_query($conn, $updateQuery);
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script> alert('Updated Successfully'); </script>";
        } else {
            echo "<script> alert('No Record Found to Update'); </script>";
        }
    }
}


if (isset($_POST["delete"])) {
    $deleteName = $_POST['deleteName'];
    $deleteQuery = "DELETE FROM FishMarketPrices WHERE species = '$deleteName' AND userID='$userid'";
    $deleteResult = mysqli_query($conn, $deleteQuery);
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> alert('Species Deleted Successfully'); </script>";
    } else {
        echo "<script> alert('No Species Found to Delete'); </script>";
    }
}


$userPrices = [];
$userPricesQuery = "SELECT * FROM FishMarketPrices WHERE userID = '$userid'";
$userPricesResult = mysqli_query($conn, $userPricesQuery);
if ($userPricesResult && mysqli_num_rows($userPricesResult) > 0) {
    while ($row = mysqli_fetch_assoc($userPricesResult)) {
        $userPrices[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Market Prices</title>
    <link rel="stylesheet" href="stylefish.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h2>Fish Market Prices</h2>

        <!-- Market Prices Form -->
        <form id="marketPricesForm" action="" method="post">
            <label for="species">Species:</label>
            <input type="text" id="species" name="species" required><br>
            <label for="marketPrice">Price:</label>
            <input type="number" id="marketPrice" name="marketPrice" step="0.01" required><br>
            <label for="action">Action:</label>
            <select id="action" name="action" required>
                <option value="update">Update</option>
                <option value="add">Add</option>
            </select><br>
            <button type="submit" name="submit">Submit</button>
        </form>

        <!-- Display User's Market Prices -->
        <h3>Your Market Prices</h3>
        <table>
            <thead>
                <tr>
                    <th>Species</th>
                    <th>Market Price</th>
                    <th>Price Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userPrices as $priceEntry) { ?>
                    <tr>
                        <td><?php echo $priceEntry['Species']; ?></td>
                        <td><?php echo $priceEntry['MarketPrice']; ?></td>
                        <td><?php echo $priceEntry['PriceDate']; ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
       
