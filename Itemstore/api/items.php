<?php
require '../vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->item_store->items;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$filter = ['name' => new MongoDB\BSON\Regex($search, 'i')];
$options = [
    'limit' => $itemsPerPage,
    'skip' => $offset
];

$items = $collection->find($filter, $options);
$totalItems = $collection->countDocuments($filter);
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items List</title>
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
        <h1>Items List</h1>
        <form id="searchForm" method="GET" action="/api/items.php">
            <input type="text" name="search" placeholder="Search for items..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
        <div class="select-container">
            <select id="itemsPerPage" onchange="changeItemsPerPage()">
                <option value="10" <?= $itemsPerPage == 10 ? 'selected' : '' ?>>Show 10 items per page</option>
                <option value="100" <?= $itemsPerPage == 100 ? 'selected' : '' ?>>Show 100 items per page</option>
            </select>
        </div>
        <div id="itemsList">
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
        </div>
        <div id="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?itemsPerPage=<?= $itemsPerPage ?>&search=<?= htmlspecialchars($search) ?>&page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php } ?>
        </div>
    </div>

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