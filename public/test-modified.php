<?php
// Save as test-fresh.php

try {
    // Connection details
    $configs = [
        // First configuration attempt (pooled)
        [
            'host' => 'aws-0-sa-east-1.pooler.supabase.com',
            'port' => '6543',
            'dbname' => 'postgres',
            'user' => 'postgres.hqnpzwiyxehxtridrit',
            'password' => 'Ethere@l@8824'
        ],
        // Second configuration attempt (direct)
        [
            'host' => 'db.hqnpzwiyxehxtridrit.supabase.co',
            'port' => '5432',
            'dbname' => 'postgres',
            'user' => 'postgres',
            'password' => 'Ethere@l@8824'
        ]
    ];
    
    $success = false;
    
    foreach ($configs as $index => $config) {
        echo "Attempting connection configuration #" . ($index + 1) . ":<br>";
        echo "Host: " . $config['host'] . "<br>";
        echo "Port: " . $config['port'] . "<br>";
        echo "Database: " . $config['dbname'] . "<br>";
        echo "Username: " . $config['user'] . "<br><br>";
        
        try {
            $dsn = sprintf(
                "pgsql:host=%s;port=%s;dbname=%s;sslmode=disable",
                $config['host'],
                $config['port'],
                $config['dbname']
            );
            
            $pdo = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5
            ]);
            
            echo "Connection successful! ✅<br><br>";
            
            $stmt = $pdo->query('SELECT current_database(), current_user');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Connected to database: " . $result['current_database'] . "<br>";
            echo "Connected as user: " . $result['current_user'] . "<br><br>";
            
            $success = true;
            break;
            
        } catch (PDOException $e) {
            echo "Connection failed ❌<br>";
            echo "Error Code: " . $e->getCode() . "<br>";
            echo "Error Message: " . $e->getMessage() . "<br><br>";
        }
    }
    
    if (!$success) {
        echo "<br>All connection attempts failed.<br>";
    }
    
} catch (Exception $e) {
    echo "General error: " . $e->getMessage() . "<br>";
}

// Display system information
echo "<br>System Information:<br>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "PDO Drivers Available: ";
print_r(PDO::getAvailableDrivers());