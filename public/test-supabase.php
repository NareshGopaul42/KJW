<?php
// Save as test-supabase.php

try {
    // Connection details from your Supabase dashboard
    $host = 'aws-0-sa-east-1.pooler.supabase.com';
    $port = '6543';
    $dbname = 'postgres';
    $user = 'postgres.hqnpzwiyxehxtridrit';
    $password = 'Ethere@l@8824';

    // Create connection string
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password;sslmode=verify-full";
    
    echo "Attempting to connect with following settings:<br>";
    echo "Host: $host<br>";
    echo "Port: $port<br>";
    echo "Database: $dbname<br>";
    echo "Username: $user<br><br>";
    
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => false
    ];

    $pdo = new PDO($dsn, $user, $password, $options);
    
    echo "Successfully connected! ✅<br><br>";
    
    // Test query
    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetch();
    echo "PostgreSQL Version: " . $version['version'] . "<br>";
    
} catch (PDOException $e) {
    echo "Connection failed ❌<br><br>";
    echo "Error Code: " . $e->getCode() . "<br>";
    echo "Error Message: " . $e->getMessage() . "<br><br>";
    
    // Additional debug info
    if ($e->getCode() == '08006') {
        echo "Troubleshooting suggestions:<br>";
        echo "1. Check if username/password are correct<br>";
        echo "2. Verify SSL settings<br>";
        echo "3. Confirm IP address is allowed in Supabase<br>";
        echo "4. Try connecting with psql command line tool<br>";
    }
}