<?php
session_start();

// Include your database connection
include 'db.php';

// Set header to return JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Check if the required data is sent
if (!isset($_POST['rating']) || !isset($_POST['educator_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing rating or educator ID.']);
    exit;
}

$user_id = $_SESSION['username'];
$rating = (int)$_POST['rating'];
$educator_id = (int)$_POST['educator_id'];

// Validate rating value
if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Invalid rating value. Must be between 1 and 5.']);
    exit;
}

try {
    // Use INSERT ... ON DUPLICATE KEY UPDATE to either insert a new rating or update an existing one.
    // This relies on the UNIQUE KEY user_educator_unique defined in the SQL table creation.
    $stmt = $conn->prepare("
        INSERT INTO educator_ratings (user_id, educator_id, rating)
        VALUES (:user_id, :educator_id, :rating)
        ON DUPLICATE KEY UPDATE rating = :rating
    ");

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':educator_id', $educator_id);
    $stmt->bindParam(':rating', $rating);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Rating saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database execution failed.']);
    }

} catch (PDOException $e) {
    // Log the error (optional) and return a general message
    // error_log("Rating save error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'A database error occurred.']);
}
?>