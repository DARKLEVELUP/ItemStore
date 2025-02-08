<?php
require '../vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->item_store->items;

$id = new MongoDB\BSON\ObjectId($_POST['id']);

$deleteResult = $collection->deleteOne(['_id' => $id]);

header("Location: /api/items.php");
?>