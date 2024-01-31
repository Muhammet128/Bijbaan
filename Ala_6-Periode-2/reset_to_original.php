<?php
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['resetOriginal']) && isset($_POST['boekId'])) {
        $boekId = $_POST['boekId'];

        try {
            // Haal de oorspronkelijke prijs op
            $getOriginalPriceSql = "SELECT Originele_prijs FROM recepteboeken WHERE Boek_id = ?";
            $getOriginalPriceStmt = $conn->prepare($getOriginalPriceSql);
            $getOriginalPriceStmt->bind_param("i", $boekId);
            $getOriginalPriceStmt->execute();
            $getOriginalPriceResult = $getOriginalPriceStmt->get_result();
            $originalPriceRow = $getOriginalPriceResult->fetch_assoc();
            $originalPrice = $originalPriceRow['Originele_prijs'];

            // Herstel naar de oorspronkelijke prijs
            $resetSql = "UPDATE recepteboeken SET Boek_prijs = ?, Korting_prijs = NULL, Status = NULL WHERE Boek_id = ?";
            $resetStmt = $conn->prepare($resetSql);
            $resetStmt->bind_param("di", $originalPrice, $boekId);
            $resetStmt->execute();

            // Stuur een succesvolle respons terug naar de client
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Stuur een foutmelding terug naar de client
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        // Stuur een foutmelding terug als de vereiste gegevens ontbreken
        echo json_encode(['success' => false, 'error' => 'Ongeldige aanvraag']);
    }
} else {
    // Stuur een foutmelding terug voor ongeldige verzoekmethode
    echo json_encode(['success' => false, 'error' => 'Ongeldige verzoekmethode']);
}
?>
