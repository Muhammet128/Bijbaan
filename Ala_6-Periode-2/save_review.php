<?php
require_once 'dbconnect.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['book_id'], $_POST['user_name'], $_POST['user_review'])) {
 
    $bookId = $_POST['book_id'];
    $userName = $_POST['user_name'];
    $userReview = $_POST['user_review'];
 
    try {
        $sql = "INSERT INTO reviews (book_id, user_name, user_review) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $bookId, $userName, $userReview);
        $stmt->execute();
       
        echo json_encode(['success' => 'Recensie succesvol opgeslagen.']);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Er is iets fout gegaan bij het opslaan van de recensie.']);
    }
} else {
    echo json_encode(['error' => 'Ongeldige aanvraag.']);
}
?>