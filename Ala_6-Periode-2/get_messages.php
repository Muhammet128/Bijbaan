<?php
// Verbinding met de database (vervang 'jouw_gegevens' door de juiste databasegegevens)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ala_6";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ontvang de status uit de querystring
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Voer validatie uit op de status (optioneel)
$statuses = ['unread', 'read', 'deleted'];
if (!in_array($status, $statuses)) {
    die("Ongeldige status");
}

// Update de status als een bericht wordt gelezen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageId = $_POST['message_id'];

    // Gebruik een prepared statement om SQL-injectie te voorkomen
    $updateQuery = $conn->prepare("UPDATE contact SET contact_Status = 'Gelezen' WHERE contact_id = ?");
    $updateQuery->bind_param('i', $messageId);
    $updateQuery->execute();
    $updateQuery->close();
}

// Gebruik een prepared statement om SQL-injectie te voorkomen
$query = $conn->prepare("SELECT * FROM contact WHERE contact_Status = ?");
$query->bind_param('s', $status);
$query->execute();
$result = $query->get_result();

// Toon de berichten
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<strong>{$row['contact_Naam']} {$row['contact_Achternaam']}</strong><br>";
        echo "E-mail: {$row['contact_Email']}<br>";
        echo "Bericht: {$row['contact_Bericht']}<br>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='message_id' value='{$row['contact_id']}'>";
        echo "<input type='submit' value='Markeer als Gelezen'>";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Geen berichten gevonden.";
}

// Sluit de databaseverbinding
$query->close();
$conn->close();
?>
