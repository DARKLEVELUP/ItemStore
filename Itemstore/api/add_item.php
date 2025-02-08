<?php
require '../vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->item_store->items;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $date_bought = $_POST['date_bought'];
    $check_date = $_POST['check_date'];
    $warranty_years = (int)$_POST['warranty_years'];
    $expiry_date = $_POST['expiry_date'];

    $insertResult = $collection->insertOne([
        'name' => $name,
        'date_bought' => $date_bought,
        'check_date' => $check_date,
        'warranty_years' => $warranty_years,
        'expiry_date' => $expiry_date
    ]);

    header("Location: /api/items.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="/index.html">Home</a></li>
            <li><a href="/api/items.php">Item List</a></li>
            <li><a href="/add_item.html">Add Item</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Add Item</h1>
        <form id="addForm" method="POST" action="/api/add_item.php">
            <div class="form-group">
                <label for="name">Item Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="date_bought">Date Bought:</label>
                <input type="date" id="date_bought" name="date_bought" required>
            </div>
            <div class="form-group">
                <label for="check_date">Check Date:</label>
                <input type="date" id="check_date" name="check_date" required>
            </div>
            <div class="form-group">
                <label for="warranty_years">Warranty (Years):</label>
                <input type="number" id="warranty_years" name="warranty_years" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
            </div>
            <button type="submit">Add Item</button>
        </form>
    </div>
</body>
</html>