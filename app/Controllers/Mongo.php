<?php
require_once __DIR__.'/vendor/autoload.php';
// namespace App\Controllers;
// use App\Database\DbUtils;


$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->selectDatabase('arcadia');
$collection = $database->selectCollection('opening');

$insertOneResult = $collection->insertOne([
    'mon' => 'Fermeture',
    'tue' => '08h00 - 18h00',
    'wed' => '08h00 - 18h00',
    'thu' => '08h00 - 18h00',
    'fri' => '08h00 - 18h00',
    'sat' => '08h00 - 18h00',
    'sun' => '08h00 - 18h00',

]);

// Requête pour obtenir tous les documents
$documents = $collection->find();

// Afficher les documents
foreach ($documents as $document) {
    var_dump($document);
}
