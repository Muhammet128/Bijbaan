
<?php
require_once 'dbconnect.php';
 
if (isset($_POST['contactId']) && isset($_POST['newStatus'])) {
    $contactId = $_POST['contactId'];
    $newStatus = $_POST['newStatus'];
 
    try {
        $sql = "UPDATE contact SET contact_Status = ? WHERE contact_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $contactId);
        $stmt->execute();
    } catch (Exception $e) {
        echo "Er is iets fout gegaan bij het bijwerken van de status.";
    }
}
?>