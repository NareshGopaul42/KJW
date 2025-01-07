<?php
// Save as test-modified-pooler.php

try {
    $user = "postgres.hqnpzwiyxehxtridrit";
    $password = "Ethere@l@8824";
    $host = "aws-0-sa-east-1.pooler.supabase.com";
    $port = "6543";
    $dbname = "postgres.hqnpzwiyxehxtridrit";  // Changed to include project reference
    
    // Try different connection string formats
    echo "Trying connection string format 1:<br>";
    $dsn1 = "pgsql:host={$host};port={$port};dbname={$dbname}";
    try {
        $pdo1 = new PDO($dsn1, $user, $password);
        echo "Connection 1 successful!<br>";
    } catch (PDOException $e) {
        echo "Connection 1 failed: " . $e->getMessage() . "<br><br>";
    }
    
    echo "Trying connection string format 2:<br>";
    $dsn2 = "postgres://{$user}:{$password}@{$host}:{$port}/{$dbname}";
    try {
        $pdo2 = new PDO($dsn2);
        echo "Connection 2 successful!<br>";
    } catch (PDOException $e) {
        echo "Connection 2 failed: " . $e->getMessage() . "<br><br>";
    }
    
    echo "Trying connection string format 3:<br>";
    $dsn3 = "pgsql:host={$host};port={$port};dbname=postgres;user={$user};password={$password}";
    try {
        $pdo3 = new PDO($dsn3);
        echo "Connection 3 successful!<br>";
    } catch (PDOException $e) {
        echo "Connection 3 failed: " . $e->getMessage() . "<br><br>";
    }
    
} catch (Exception $e) {
    echo "General error: " . $e->getMessage() . "<br>";
}

// Display PHP and PDO information
echo "<br>PHP Version: " . PHP_VERSION . "<br>";
echo "PDO Drivers available: ";
print_r(PDO::getAvailableDrivers());
echo "<br>PostgreSQL client version: " . (function_exists('pg_version') ? print_r(pg_version(), true) : 'Not available');