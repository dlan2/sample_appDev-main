<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
    }

    $user_id = $_SESSION['username'];
    $record_type_id = $_POST['record_type_id'];

    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUser->execute([$user_id]);
    if ($checkUser->rowCount() === 0) {
        die("Error: User does not exist in the database.");
    }

    $checkType = $conn->prepare("SELECT * FROM record_types WHERE id = ?");
    $checkType->execute([$record_type_id]);
    if ($checkType->rowCount() === 0) {
        die("Error: Selected record type does not exist.");
    }

    $sql = "INSERT INTO record_requests 
            (request_id, user_id, record_type_id, status, date_requested) 
            VALUES (UUID(), ?, ?, 'Pending', NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$user_id, $record_type_id])) {
        header("Location: records.php?success=1");
        exit;
    } else {
        echo "Database Error: Could not submit request.";
    }
}
?>