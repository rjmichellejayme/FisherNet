<?php
$conn = new mysqli('localhost', 'root', '', 'fishernet');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = 1;

$sql = "SELECT * FROM Users WHERE UserID = 18";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = isset($row['Username']) ? $row['Username'] : '';
    $email = isset($row['Email']) ? $row['Email'] : '';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>Profile</h1>
        <nav>
            <ul>
                <!-- Home    -->
            </ul>
        </nav>
    </header>
    <main>
        <?php if (!empty($username)) : ?>
            <h2>Welcome, <?php echo $username; ?></h2>
        <?php endif; ?>
        <?php if (!empty($email)) : ?>
            <p>Email: <?php echo $email; ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
</body>
</html>
