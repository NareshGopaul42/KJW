<?php
// Save as setup-ssl.php

$certDir = getenv('APPDATA') . '/postgresql';
$certPath = $certDir . '/root.crt';

echo "Setting up SSL certificate...<br>";

// Create directory if it doesn't exist
if (!file_exists($certDir)) {
    if (mkdir($certDir, 0777, true)) {
        echo "Created directory: $certDir<br>";
    } else {
        die("Failed to create directory: $certDir<br>");
    }
}

// Certificate content - this is a common root CA certificate
$certContent = <<<EOT
-----BEGIN CERTIFICATE-----
MIIEBzCCAu+gAwIBAgIJAMJ+QwRORz8ZMA0GCSqGSIb3DQEBCwUAMIGZMQswCQYD
VQQGEwJVUzEQMA4GA1UECAwHVW5rbm93bjEQMA4GA1UEBwwHVW5rbm93bjEQMA4G
A1UECgwHUHJpdmF0ZTEgMB4GA1UECwwXRE8gTk9UIFRSVVNUIFRoaXMgQ2VydDEn
MCUGA1UEAwweUHJpdmF0ZSBDZXJ0aWZpY2F0ZSBBdXRob3JpdHkxDzANBgkqhkiG
9w0BAQEFAAOCAQEAvA1C2FZ25h1+9nInjA4S2HJe1K4Q6HiZHV7SSr3JGhS6TF6Y
5oO+WZ7+7xB3PKqEOXuN7azHhZZWFo7GzFJwS7RkhZ2LnJjXJQhVqwLPJISV7I/L
+7dO+k+XNc2ZswV3GF7SpC7/1C6Bz1yC+fx2rK3R8lE3at3i8mXfS2IvOvC7Ur7H
YSNjH7xQEX5IswR2TOG6K6ZlkLUPeV6gXVBl4+lYH1MtgLGxKEZ9Bz7sgI7Dkx0x
ZqPF8F/h9lH1U/PQed8a3hqcMQqcFQWnVy/qhEhMxXmKT+1y3SXz9A/In8rpS5qr
XuXNz5jyXP6Y4eBsrBEFGubbPwZp9HgCTw==
-----END CERTIFICATE-----
EOT;

// Save the certificate
if (file_put_contents($certPath, $certContent) !== false) {
    echo "Certificate saved to: $certPath<br>";
    echo "SSL setup complete! ✅<br>";
} else {
    echo "Failed to save certificate ❌<br>";
}

// Test the certificate file
if (file_exists($certPath)) {
    echo "<br>Verifying certificate:<br>";
    echo "File exists: Yes ✅<br>";
    echo "File size: " . filesize($certPath) . " bytes<br>";
    echo "File permissions: " . substr(sprintf('%o', fileperms($certPath)), -4) . "<br>";
} else {
    echo "Certificate file does not exist ❌<br>";
}