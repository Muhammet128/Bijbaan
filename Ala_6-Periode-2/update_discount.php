<?php
require_once 'dbconnect.php';

// Controleer of de vereiste parameters zijn ontvangen
if (isset($_POST['bookId']) && isset($_POST['newPrice'])) {
    $bookId = $_POST['bookId'];
    $newPrice = $_POST['newPrice'];

    // Haal de oude prijs op uit de database
    $oldPriceQuery = $conn->prepare("SELECT Boek_prijs FROM recepteboeken WHERE Boek_id = ?");
    $oldPriceQuery->bind_param("i", $bookId);
    $oldPriceQuery->execute();
    $oldPriceResult = $oldPriceQuery->get_result();
    $oldPriceRow = $oldPriceResult->fetch_assoc();
    $oldPrice = $oldPriceRow['Boek_prijs'];

    // Bereken de korting en de nieuwe prijs
    $discount = $oldPrice - $newPrice;
    $discountedPrice = $oldPrice - $discount;

    // Bereken de einddatum van de korting (7 dagen vanaf vandaag)
    $endDate = date('Y-m-d', strtotime('+7 days'));

    // Voorbereid statement gebruiken om SQL-injecties te voorkomen
    $updateQuery = $conn->prepare("UPDATE recepteboeken SET Boek_prijs = ?, Status = 'korting', Korting_prijs = ?, Korting_einddatum = ? WHERE Boek_id = ?");
    $updateQuery->bind_param("dssi", $discountedPrice, $discount, $endDate, $bookId);

    if ($updateQuery->execute()) {
        // Retourneer een JSON-response
        $response = ['success' => true];
    } else {
        // Retourneer een JSON-response met een foutmelding
        $response = ['success' => false, 'error' => $conn->error];
    }

    $updateQuery->close(); // Sluit het prepared statement
} else {
    // Retourneer een JSON-response als de vereiste parameters ontbreken
    $response = ['success' => false, 'error' => 'Vereiste parameters ontbreken'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
