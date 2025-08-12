<?php
// Require the MongoDB library (install via composer: composer require mongodb/mongodb)
require 'vendor/autoload.php';

use MongoDB\Client;

try {
    // Connect to MongoDB (default is localhost:27017)
    $client = new Client("mongodb://mongodb:27017");
    
    // Select database and collection
    $database = $client->selectDatabase('my_database');
    $collection = $database->selectCollection('users');
    
    // CREATE: Insert a single document
    $insertResult = $collection->insertOne([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'age' => 30,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);
    echo "Inserted document with ID: " . $insertResult->getInsertedId() . "\n";
    
    // CREATE: Insert multiple documents
    $insertManyResult = $collection->insertMany([
        ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'age' => 25],
        ['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'age' => 35]
    ]);
    echo "Inserted " . $insertManyResult->getInsertedCount() . " documents\n";
    
    // READ: Find one document
    $user = $collection->findOne(['name' => 'John Doe']);
    echo "Found user: " . print_r($user, true) . "\n";
    
    // READ: Find multiple documents with query
    $cursor = $collection->find(['age' => ['$gt' => 25]]);
    echo "Users over 25:\n";
    foreach ($cursor as $document) {
        echo $document['name'] . " (" . $document['age'] . ")\n";
    }
    
    // UPDATE: Modify a document
    $updateResult = $collection->updateOne(
        ['email' => 'john@example.com'],
        ['$set' => ['age' => 31]]
    );
    echo "Modified " . $updateResult->getModifiedCount() . " document\n";
    
    // DELETE: Remove a document
    $deleteResult = $collection->deleteOne(['email' => 'bob@example.com']);
    echo "Deleted " . $deleteResult->getDeletedCount() . " document\n";
    
    // Count documents
    $count = $collection->countDocuments();
    echo "Total documents in collection: " . $count . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}