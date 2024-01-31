<?php
require_once 'dbconnect.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['contactId'])) {
        $contactId = $_POST['contactId'];
 
        $updateSql = $conn->prepare("UPDATE contact SET verwijderd = 1 WHERE contact_id = ?");
        $updateSql->bind_param("i", $contactId);
 
        if ($updateSql->execute()) {
            header("Location: archief.php");
            exit;
        } else {
            echo "Er is iets fout gegaan bij het verwijderen: " . $conn->error;
        }
 
        $updateSql->close();
    }
}
?>
 