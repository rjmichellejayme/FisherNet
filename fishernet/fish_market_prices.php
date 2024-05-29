<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Market Prices</title>
    <link rel="stylesheet" href="stylefish.css">
</head>
<body>
    <header>
        <h1>Fisherman Website</h1>
    </header>
    <main>
        <h2>Fish Market Prices</h2>

        <table id="marketPricesTable">
            <thead>
                <tr>
                    <th>Species</th>
                    <th>Market Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>    </tbody>
        </table>
       
        <form id="marketPricesForm">
            <label for="species">Species:</label>
            <input type="text" id="species" name="species" required><br>
            <label for="marketPrice">Market Price:</label>
            <input type="number" id="marketPrice" name="marketPrice" step="0.01" required><br>
            <label for="action">Action:</label>
            <select id="action" name="action" required>
                <option value="update">Update</option>
                <option value="add">Add</option>
            </select><br>
            <button type="submit">Submit</button>
        </form>
    </main>
    <nav id=back>
        <a href="index_fish.php">Home</a>
    </nav>
    <footer>
        <p>&copy; 2024 Fisherman Website</p>
    </footer>
 
</body>
</html>
