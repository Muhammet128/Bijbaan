<?php
require_once 'dbconnect.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
   
    try {
        $sql = "SELECT * FROM reviews WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($reviews);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Er is iets fout gegaan bij het ophalen van recensies.']);
    }
} else {
    echo json_encode(['error' => 'Ongeldige aanvraag.']);
}
?>