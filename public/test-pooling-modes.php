<?php
// Save as test-dns-connection.php

function checkDNS($host) {
    echo "Checking DNS for $host...<br>";
    $ip = gethostbyname($host);
    if ($ip === $host) {
        echo "❌ Could not resolve hostname<br>";
        return false;
    } else {
        echo "✅ Resolved to IP: $ip<br>";
        return true;
    }
}

try {
    $certPath = getenv('APPDATA') . '/postgresql/root.crt';
    
    $configs = [
        // Direct connection (corrected hostname)
        [
            'name' => 'Direct Connection',
            'host' => 'db.hqnpzwiyxehxtridrit.supabase.co',
            'port' => '5432',
            'dbname' => 'postgres',
            'user' => 'postgres',
            'sslmode' => 'verify-full'
        ],
        // Session mode with corrected host
        [
            'name' => 'Session Mode (Supavisor)',
            'host' => 'aws-0-sa-east-1.pooler.supabase.com',
            'port' => '5432',
            'dbname' => 'postgres',
            'user' => 'postgres.hqnpzwiyxehxtridrit',
            'sslmode' => 'verify-full'
        ]
    ];
    
    foreach ($configs as $config) {
        echo "<br><strong>Testing " . $config['name'] . ":</strong><br>";
        echo "Host: " . $config['host'] . "<br>";
        echo "Port: " . $config['port'] . "<br>";
        echo "Database: " . $config['dbname'] . "<br>";
        echo "Username: " . $config['user'] . "<br>";
        echo "SSL Mode: " . $config['sslmode'] . "<br><br>";
        
        // Check DNS resolution first
        if (!checkDNS($config['host'])) {
            echo "Skipping connection attempt due to DNS resolution failure<br>";
            echo "<hr>";
            continue;
        }
        
        try {
            $dsn = sprintf(
                "pgsql:host=%s;port=%s;dbname=%s;sslmode=%s;sslcert=%s",
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['sslmode'],
                $certPath
            );
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5
            ];
            
            $pdo = new PDO($dsn, $config['user'], 'Ethere@l@8824', $options);
            
            echo "Connection successful! ✅<br>";
            
            $stmt = $pdo->query('SELECT current_database(), current_user, version()');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Database: " . $result['current_database'] . "<br>";
            echo "User: " . $result['current_user'] . "<br>";
            echo "Version: " . $result['version'] . "<br>";
            
        } catch (PDOException $e) {
            echo "Connection failed ❌<br>";
            echo "Error: " . $e->getMessage() . "<br>";
            
            // Additional error information
            if (strpos($e->getMessage(), 'Tenant or user not found') !== false) {
                echo "<br>Possible issues:<br>";
                echo "1. Username format might be incorrect<br>";
                echo "2. Project reference might be wrong<br>";
                echo "3. Connection pooling might require different credentials<br>";
            }
        }
        
        echo "<hr>";
    }
    
} catch (Exception $e) {
    echo "General error: " . $e->getMessage() . "<br>";
}

// Display full system information
echo "<br>System Information:<br>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "OpenSSL Version: " . OPENSSL_VERSION_TEXT . "<br>";
echo "SSL Certificate Path: " . $certPath . "<br>";
echo "Operating System: " . PHP_OS . "<br>";
echo "PDO Drivers: " . implode(", ", PDO::getAvailableDrivers()) . "<br>";

// Test DNS resolution for both IPv4 and IPv6
echo "<br>DNS Resolution Tests:<br>";
$hosts = [
    'aws-0-sa-east-1.pooler.supabase.com',
    'db.hqnpzwiyxehxtridrit.supabase.co'
];

foreach ($hosts as $host) {
    echo "<br>Testing $host:<br>";
    
    // IPv4
    $ipv4 = dns_get_record($host, DNS_A);
    echo "IPv4 records: ";
    print_r($ipv4);
    
    // IPv6
    $ipv6 = dns_get_record($host, DNS_AAAA);
    echo "<br>IPv6 records: ";
    print_r($ipv6);
}