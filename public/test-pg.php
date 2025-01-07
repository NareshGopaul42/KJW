<?php
// Save as test-pg.php

echo "Testing PostgreSQL connection...<br><br>";

$conn_string = "host=aws-0-sa-east-1.pooler.supabase.com " .
               "port=6543 " .
               "dbname=postgres " .
               "user=postgres.hqnpzwiyxehxtridrit " .
               "password=Ethere@l@8824 " .
               "sslmode=require";

echo "Connection string (without password):<br>";
echo preg_replace('/password=.*?(\s|$)/', 'password=******* ', $conn_string) . "<br><br>";

try {
    if (!function_exists('pg_connect')) {
        throw new Exception('PostgreSQL extension is not installed');
    }
    
    $conn = pg_connect($conn_string);
    
    if ($conn) {
        echo "Connected successfully!<br>";
        $result = pg_query($conn, "SELECT version()");
        if ($result) {
            $version = pg_fetch_result($result, 0, 0);
            echo "PostgreSQL version: " . $version;
        }
        pg_close($conn);
    } else {
        echo "Connection failed<br>";
        echo "Last error: " . pg_last_error();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    
    // Additional diagnostic information
    echo "<br>PHP version: " . PHP_VERSION . "<br>";
    echo "Loaded extensions:<br>";
    print_r(get_loaded_extensions());
}