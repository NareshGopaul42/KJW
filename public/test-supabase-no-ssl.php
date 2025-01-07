<?php
// Save as test-supabase-no-ssl.php

try {
    $host = 'aws-0-sa-east-1.pooler.supabase.com';
    $port = '6543';
    $dbname = 'postgres';
    $user = 'postgres.hqnpzwiyxehxtridrit';
    $password = 'Ethere@l@8824';

    // Modified connection string to disable SSL verification
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=disable";
    
    echo "Attempting to connect with following settings:<br>";
    echo "Host: $host<br>";
    echo "Port: $port<br>";
    echo "Database: $dbname<br>";
    echo "Username: $user<br>";
    echo "SSL Mode: disable<br><br>";
    
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "Successfully connected! ✅<br><br>";
    
    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetch();
    echo "PostgreSQL Version: " . $version['version'] . "<br>";
    
} catch (PDOException $e) {
    echo "Connection failed ❌<br><br>";
    echo "Error Code: " . $e->getCode() . "<br>";
    echo "Error Message: " . $e->getMessage() . "<br><br>";
}