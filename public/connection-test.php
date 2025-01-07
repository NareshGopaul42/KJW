<?php
// Save as test-corrected.php

try {
    $certPath = getenv('APPDATA') . '/postgresql/root.crt';
    
    // Connection details with corrected project ID
    $config = [
        'host' => 'aws-0-sa-east-1.pooler.supabase.com',
        'port' => '6543',  // Using transaction mode
        'dbname' => 'postgres',
        'user' => 'postgres.hqnpzwiyxehxtridriit',  // Note the double 'i'
        'password' => 'Ethere@l@8824'
    ];
    
    echo "Testing connection with corrected project ID:<br>";
    echo "Host: " . $config['host'] . "<br>";
    echo "Port: " . $config['port'] . "<br>";
    echo "Database: " . $config['dbname'] . "<br>";
    echo "Username: " . $config['user'] . "<br><br>";
    
    // Build connection string
    $dsn = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s;sslmode=verify-full;sslcert=%s",
        $config['host'],
        $config['port'],
        $config['dbname'],
        $certPath
    );
    
    // Set PDO options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_EMULATE_PREPARES => true  // Required for transaction mode
    ];
    
    $pdo = new PDO($dsn, $config['user'], $config['password'], $options);
    
    echo "Connection successful! ✅<br><br>";
    
    // Test the connection
    $stmt = $pdo->query('SELECT current_database(), current_user, version()');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Connected to database: " . $result['current_database'] . "<br>";
    echo "Connected as user: " . $result['current_user'] . "<br>";
    echo "Version: " . $result['version'] . "<br>";
    
} catch (PDOException $e) {
    echo "Connection failed ❌<br>";
    echo "Error Code: " . $e->getCode() . "<br>";
    echo "Error Message: " . $e->getMessage() . "<br>";
    
    // Additional error information
    if (strpos($e->getMessage(), 'Tenant or user not found') !== false) {
        echo "<br>Debug information:<br>";
        echo "1. Project ID: hqnpzwiyxehxtridriit<br>";
        echo "2. Full connection string (without password):<br>";
        echo $dsn . "<br>";
    }
}

// Display system information
echo "<br>System Information:<br>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "OpenSSL Version: " . OPENSSL_VERSION_TEXT . "<br>";
echo "SSL Certificate Path: " . $certPath . "<br>";
echo "PDO Drivers: " . implode(", ", PDO::getAvailableDrivers()) . "<br>";