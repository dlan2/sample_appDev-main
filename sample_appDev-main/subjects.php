<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$types_stmt = $conn->prepare("SELECT * FROM record_types");
$types_stmt->execute();
$types = $types_stmt->fetchAll(PDO::FETCH_ASSOC);

$user_id = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Records - Smart Campus Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="cake.png"/>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<nav class="navbar sticky-top navbar-dark" style="background-color: #06326b;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="cake.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
      <u>Smart Campus App</u>
    </a>
  </div>
</nav>

<div class="main-container">
    <div class="sidebar text-white p-3">        
        <a href="profile.php" class="text-white d-block mb-3">Profile</a>
        <a href="subjects.php" class="text-warning fw-bold d-block mb-3">Subjects</a>
        <a href="records.php" class="text-white d-block mb-3">Records</a>
        <a href="ecd.php" class="text-white d-block mb-3">ECD</a>
        <a href="about.php" class="text-white d-block mb-3">About</a>
        <a href="index.php" class="btn btn-danger mt-5">Sign Out</a>
    </div>

    
<main>
      subjects
    </main>

</div>

</body>
</html>
