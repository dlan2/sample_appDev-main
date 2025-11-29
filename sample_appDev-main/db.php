<?php
$host = "localhost";
$dbname = "accslogin"; // Your database name
$user = "root";        // MySQL username
$pass = "";            // MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}
?>

