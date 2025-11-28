<?php
// config.php
// Deliberately simple and insecure configuration for CTF use only.

$host = '192.168.11.2';
$db   = 'hackit';
$user = 'hackit';
$pass = '5gEfTP5B3_1@ii8g';

// Create mysqli connection (PHP 8.2 compatible)
$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// The flag that should be revealed after "successful" login:
$FLAG = 'FLAG{YellowStorm1701.php}';
?>