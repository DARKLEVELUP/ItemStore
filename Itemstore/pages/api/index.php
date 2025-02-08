<?php
require '../vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->item_store->items;

// Fetch items from the database
$items = $collection->find([], ['sort' => ['date_bought' => -1]]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Tracker</title>
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

    <h1>Item List</h1>
    <table border="1">
    <tr>
        <th>Item Name</th>
        <th>Purchase Date</th>
        <th>Warranty Years</th>
        <th>Expiry Date</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($items as $item) { ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $item['date_bought'] ?></td>
        <td><?= $item['warranty_years'] ?></td>
        <td><?= $item['expiry_date'] ?></td>
        <td>
            <button onclick="showUpdateForm('<?= $item['_id'] ?>', '<?= htmlspecialchars($item['name']) ?>', '<?= $item['date_bought'] ?>', '<?= $item['check_date'] ?>', '<?= $item['warranty_years'] ?>', '<?= $item['expiry_date'] ?>')">Update</button>
            <form action="/api/delete_item.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $item['_id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

    <div id="updateForm" style="display:none;">
        <h2>Update Item</h2>
        <form id="updateItemForm" method="POST" action="/api/update_item.php">
            <input type="hidden" id="update_id" name="id">
            <div class="form-group">
                <label for="update_name">Item Name:</label>
                <input type="text" id="update_name" name="name" required>
            </div>
            <div class="form-group">
                <label for="update_date_bought">Date Bought:</label>
                <input type="date" id="update_date_bought" name="date_bought" required>
            </div>
            <div class="form-group">
                <label for="update_check_date">Check Date:</label>
                <input type="date" id="update_check_date" name="check_date" required>
            </div>
            <div class="form-group">
                <label for="update_warranty_years">Warranty (Years):</label>
                <input type="number" id="update_warranty_years" name="warranty_years" required>
            </div>
            <div class="form-group">
                <label for="update_expiry_date">Expiry Date:</label>
                <input type="date" id="update_expiry_date" name="expiry_date" required>
            </div>
            <button type="submit">Update Item</button>
        </form>
    </div>

    <script src="/script.js"></script>
</body>
</html>