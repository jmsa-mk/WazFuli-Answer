<?php

// TASK 1 - DATABASE CONNECTION
// Your mission in this file:
// 1. Create a PDO connection to the MySQL database.
// 2. Use localhost, username root, an empty password, and database db_wazfuli for your local setup.
// 3. Store the connection in $conn so other files can use it.
// 4. Use utf8mb4 for the connection. Handle connection errors without showing database details.

// TODO: Write your PHP code here.

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'db_wazfuli';

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

