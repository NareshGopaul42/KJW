<?php
echo "<h2>PostgreSQL Extension Status:</h2>";
echo "PDO PostgreSQL extension loaded: " . (extension_loaded('pdo_pgsql') ? 'Yes ✅' : 'No ❌') . "<br>";
echo "PostgreSQL extension loaded: " . (extension_loaded('pgsql') ? 'Yes ✅' : 'No ❌') . "<br>";

if (extension_loaded('pdo_pgsql')) {
    echo "<br>Available PDO drivers:<br>";
    print_r(PDO::getAvailableDrivers());
}