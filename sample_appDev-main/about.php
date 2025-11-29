<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - Smart Campus Hub</title>
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

<div class="main-container d-flex">
    <div class="sidebar text-white p-3">
        <a href="profile.php" class="text-white d-block mb-3">Profile</a>
        <a href="subjects.php" class="text-white d-block mb-3">Subjects</a>
        <a href="records.php" class="text-white d-block mb-3">Records</a>
        <a href="ecd.php" class="text-white d-block mb-3">ECD</a>
        <a href="about.php" class="text-warning fw-bold d-block mb-3">About</a>
        <a href="index.php" class="btn btn-danger mt-5">Sign Out</a>
    </div>

    <div class="flex-grow-1 p-4 bg-white shadow-sm" style="min-height: 80vh;">
        <h2>About Smart Campus Hub</h2>

<p>
    Smart Campus Hub is a school-driven platform developed to provide students and staff with a
    simple, organized, and accessible system for managing academic information. It brings together
    essential features into one convenient place, allowing users to access what they need quickly
    and efficiently.
</p>

<p>
    This project was created to support smoother campus operations, reduce manual paperwork, and
    offer a more modern approach to handling student records, subjects, and personal information.
    With its clean interface and easy navigation, Smart Campus Hub aims to improve productivity and
    make academic processes more manageable for everyone.
</p>

<p>
    Our platform includes features such as profile viewing, subject tracking, academic record
    requests, ECD access, and other helpful tools designed specifically for school use.
</p>

<p>
    Thank you for using Smart Campus Hub — a project made with the goal of enhancing school
    efficiency and making campus life easier.
</p>


    </div>
</div>

</body>
</html>
