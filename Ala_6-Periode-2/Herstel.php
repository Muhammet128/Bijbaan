<?php
require_once 'dbconnect.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['contactId'])) {
        $contactId = $_POST['contactId'];
 
        // Herstel het bericht door de waarde van 'verwijderd' terug te zetten naar 0
        $updateSql = $conn->prepare("UPDATE contact SET verwijderd = 0 WHERE contact_id = ?");
        $updateSql->bind_param("i", $contactId);
 
        if ($updateSql->execute()) {
            // Update de contact_Status naar "Niet gelezen"
            $updateStatusSql = $conn->prepare("UPDATE contact SET contact_Status = 'Niet gelezen' WHERE contact_id = ?");
            $updateStatusSql->bind_param("i", $contactId);
            $updateStatusSql->execute();
           
            echo "Bericht is hersteld.";
        } else {
            echo "Er is iets fout gegaan bij het herstellen van het bericht: " . $conn->error;
        }
 
        $updateSql->close();
        $updateStatusSql->close();
    }
}
?>