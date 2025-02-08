<?php
require '../vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->item_store->items;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $name = $_POST['name'];
    $date_bought = $_POST['date_bought'];
    $check_date = $_POST['check_date'];
    $warranty_years = (int)$_POST['warranty_years'];
    $expiry_date = $_POST['expiry_date'];

    $updateResult = $collection->updateOne(
        ['_id' => $id],
        ['$set' => [
            'name' => $name,
            'date_bought' => $date_bought,
            'check_date' => $check_date,
            'warranty_years' => $warranty_years,
            'expiry_date' => $expiry_date
        ]]
    );

    header("Location: /api/items.php");
    exit;
}
?>