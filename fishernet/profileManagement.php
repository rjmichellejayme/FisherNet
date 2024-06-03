<?php
include 'dbfish.php';
session_start();

if (empty($_SESSION["UserID"])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION["UserID"];

$userInfoQuery = "SELECT * FROM users WHERE UserID = '$userid'";
$userInfoResult = mysqli_query($conn, $userInfoQuery);
$userInfo = mysqli_fetch_assoc($userInfoResult);

if (isset($_POST["updatePassword"])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if ($currentPassword === $userInfo['Password']) {
        if ($newPassword === $confirmNewPassword) {
            $updateQuery = "UPDATE users SET Password='$newPassword' WHERE UserID='$userid'";
            mysqli_query($conn, $updateQuery);
            echo "<script> alert('Password Updated Successfully'); </script>";
        } else {
            echo "<script> alert('New Passwords Do Not Match'); </script>";
        }
    } else {
        echo "<script> alert('Incorrect Current Password'); </script>";
    }
}

if (isset($_POST["deleteAccount"])) {
    $deleteRelatedQuery = "DELETE FROM catchlogbook WHERE UserID = '$userid'";
    mysqli_query($conn, $deleteRelatedQuery);
    $deleteRelatedQuery = "DELETE FROM maintenancelog WHERE EquipID IN (SELECT EquipID FROM equipment WHERE UserID = '$userid')";
    mysqli_query($conn, $deleteRelatedQuery);

    $deleteRelatedQuery = "DELETE FROM equipment WHERE UserID = '$userid'";
    mysqli_query($conn, $deleteRelatedQuery);

    $deleteRelatedQuery = "DELETE FROM fishmarketprices WHERE UserID = '$userid'";
    mysqli_query($conn, $deleteRelatedQuery);

    $deleteRelatedQuery = "DELETE FROM fishingzones WHERE UserID = '$userid'";
    mysqli_query($conn, $deleteRelatedQuery);



    $deleteQuery = "DELETE FROM users WHERE UserID = '$userid'";
    mysqli_query($conn, $deleteQuery);
    
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <link rel="stylesheet" href="stylefish.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <h2>Profile Management</h2>
        <br>
        <h3>Update Password</h3>
        <form action="" method="post">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required><br>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required><br>
            <label for="confirmNewPassword">Confirm New Password:</label>
            <input type="password" id="confirmNewPassword" name="confirmNewPassword" required><br>
            <button type="submit" name="updatePassword">Update Password</button>
        </form>
        <br>
        <h3>Delete Account</h3>
        <form action="" method="post">
            <label for="confirmDelete">Type DELETE to confirm:</label>
            <input type="text" id="confirmDelete" name="confirmDelete" required><br>
            <button type="submit" name="deleteAccount">Delete Account</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
