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

//  Fetch ALL Educators and the current user's rating FROM THE TABLE
$educators_stmt = $conn->prepare("
    SELECT 
        e.id, 
        e.name,
        COALESCE(r.rating, 0) AS current_rating
    FROM 
        educators e
    LEFT JOIN 
        educator_ratings r 
        ON e.id = r.educator_id AND r.user_id = :user_id
    ORDER BY 
        e.name ASC
");
$educators_stmt->execute(['user_id' => $user_id]);
$educators = $educators_stmt->fetchAll(PDO::FETCH_ASSOC);


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
        <a href="subjects.php" class="text-white d-block mb-3">Subjects</a>
        <a href="records.php" class="text-white d-block mb-3">Records</a>
        <a href="ecd.php" class="text-warning fw-bold d-block mb-3">ECD</a>
        <a href="about.php" class="text-white d-block mb-3">About</a>
        <a href="index.php" class="btn btn-danger mt-5">Sign Out</a>
    </div>

    
<main>
<div>
<h2 class= "mb-2">Educators Conduct Data</h2>
  <p class="mb-4">Click a star to rate the educator's conduct and performance.</p>

        <?php if (empty($educators)): ?>
            <div class="alert alert-info">No educators found to rate.</div>
        <?php else: ?>
            <div id="rating-alerts" class="mb-3">
                <div id="rating-message" class="alert alert-success fw-bold" style="display: none;">Rating saved successfully!</div>
                <div id="rating-error" class="alert alert-danger fw-bold" style="display: none;">Error saving rating.</div>
            </div>

            <div class="list-group">
                <?php foreach ($educators as $educator):
                    $educator_id = htmlspecialchars($educator['id']);
                    $educator_name = htmlspecialchars($educator['name']);
                    $current_rating = (int)$educator['current_rating'];
                ?>
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-2 shadow-sm">
                        <h5 class="mb-1"><?php echo $educator_name; ?></h5>

                        <div class="rating-container d-flex align-items-center" data-educator-id="<?php echo $educator_id; ?>">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span
                                    class="star star-<?php echo $educator_id; ?> me-1"
                                    data-value="<?php echo $i; ?>"
                                    data-educator-id="<?php echo $educator_id; ?>"
                                    style="font-size: 1.5rem; cursor: pointer; color: gold;"
                                >
                                    &#9733; </span>
                            <?php endfor; ?>
                            <span id="current-rating-text-<?php echo $educator_id; ?>" class="ms-3 text-primary fw-bold rating-display">
                                <?php echo $current_rating > 0 ? $current_rating . '/5' : 'Not Rated'; ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

</main>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const $message = $('#rating-message');
        const $error = $('#rating-error');

        // Function update visual appearance of stars
        function updateStars(educatorId, rating) {
            const $stars = $(`.star-${educatorId}`);
            const $ratingText = $(`#current-rating-text-${educatorId}`);

            $stars.each(function() {
                const starValue = $(this).data('value');
                $(this).toggleClass('rated', starValue <= rating);
                $(this).css('color', starValue <= rating ? 'gold' : '#ccc');
            });
            $ratingText.text(rating > 0 ? rating + '/5' : 'Not Rated');
        }

        // Initialize stars for all educators on page load
        $('.rating-container').each(function() {
            const educatorId = $(this).data('educator-id');
            // Extract the initial rating 
            const initialText = $(`#current-rating-text-${educatorId}`).text();
            let initialRating = 0;
            if (initialText.includes('/')) {
                initialRating = parseInt(initialText.split('/')[0]);
            }
            updateStars(educatorId, initialRating);
        });

        // hover effect
        $('.star').on('mouseover', function() {
            const educatorId = $(this).data('educator-id');
            const hoverValue = $(this).data('value');

            // Temporarily update all stars for THIS educator
            $(`.star-${educatorId}`).each(function() {
                const starValue = $(this).data('value');
                $(this).css('color', starValue <= hoverValue ? 'gold' : '#ccc');
            });
        }).on('mouseout', function() {
            const educatorId = $(this).data('educator-id');
            // Revert to the current saved rating on mouseout
            const currentRating = $(`.star-${educatorId}.rated`).length;
            updateStars(educatorId, currentRating);
        });

        // Handle click event Saving rating
        $('.star').on('click', function() {
            const selectedRating = $(this).data('value');
            const educatorId = $(this).data('educator-id');

            // 1. Send rating to the server using AJAX
            $.ajax({
                type: "POST",
                url: "save_rating.php",
                data: {
                    rating: selectedRating,
                    educator_id: educatorId
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // 2. Update visual status on success
                        updateStars(educatorId, selectedRating);
                        $message.fadeIn().delay(2000).fadeOut();
                        $error.hide();
                    } else {
                        // 3. Handle failure
                        $error.text(response.message || 'An error occurred while saving the rating.').fadeIn().delay(3000).fadeOut();
                        $message.hide();
                    }
                },
                error: function() {
                    // 4. Handle AJAX error
                    $error.text('AJAX Error: Could not connect to the server.').fadeIn().delay(3000).fadeOut();
                    $message.hide();
                }
            });
        });
    });
</script>

</body>
</html>
