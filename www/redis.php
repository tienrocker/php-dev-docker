<?php
// Connect to Redis
$redis = new Redis();
try {
    $redis->connect('redis', 6379); // Host and port (default is localhost:6379)
    
    // Optional: Authenticate if your Redis server requires a password
    // $redis->auth('your_password');

    // Set a simple key-value pair
    $redis->set('name', 'John Doe');
    
    // Set a value with expiration (in seconds)
    $redis->setex('temporary_key', 3600, 'This expires in 1 hour');
    
    // Work with a list
    $redis->rPush('mylist', 'item1'); // Add to right end
    $redis->rPush('mylist', 'item2');
    
    // Work with a hash (like an associative array)
    $redis->hSet('user:1', 'name', 'Alice');
    $redis->hSet('user:1', 'age', '25');
    
    // Retrieve values
    $name = $redis->get('name');
    $listItems = $redis->lRange('mylist', 0, -1); // Get all items
    $userData = $redis->hGetAll('user:1');
    
    // Output results
    echo "Name: " . $name . "\n";
    echo "List items: " . implode(', ', $listItems) . "\n";
    echo "User data: " . print_r($userData, true) . "\n";
    
    // Delete a key
    $redis->del('temporary_key');

} catch (Exception $e) {
    echo "Error connecting to Redis: " . $e->getMessage();
}

// Close connection
$redis->close();