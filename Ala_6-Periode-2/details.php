<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Details-admin.css">
    <title>Contact Details</title>
</head>
<body>
    <?php
    require_once 'dbconnect.php';
 
    if (isset($_GET['contact_id'])) {
        $contactId = $_GET['contact_id'];
 
        try {
            $sql = "SELECT contact_id, contact_Naam, contact_Achternaam, contact_Email, contact_Bericht FROM contact WHERE contact_id = $contactId";
            $result = $conn->query($sql);
 
            if ($result && $result->num_rows > 0) {
                $contact = $result->fetch_assoc();
                ?>
                <button class="back-button" onclick="goBack()">Terug</button>
                <div class="Details-container">
                    <?php echo "Contact ID: " . $contact['contact_id'] . "<br><br>";?>
                    <?php echo "Naam: " . $contact['contact_Naam'] . " " . $contact['contact_Achternaam'] . "<br><br>";?>
                    <?php echo "E-mail: " . $contact['contact_Email'] . "<br>";?>
                    <hr>
                    <?php echo "Bericht: " . $contact['contact_Bericht'] . "<br>";?>
 
                    <form action="verwijderen.php" method="post">
                        <input type="hidden" name="contactId" value="<?php echo $contactId; ?>">
                        <button type="submit">Verwijderen</button>
                    </form>
                </div>
                <?php
            } else {
                echo "Geen contact gevonden voor het opgegeven ID.";
            }
        } catch (Exception $e) {
            echo "Er is iets fout gegaan met ophalen.";
        }
 
        // Controleer of er een contact_id is opgegeven in de URL
        $updateStatusSql = $conn->prepare("UPDATE contact SET contact_Status = 'Gelezen' WHERE contact_id = ? AND contact_Status = 'Niet gelezen'");
        $updateStatusSql->bind_param("i", $contactId);
        $updateStatusSql->execute();
 
        // Haal het bericht op uit de database
        $detailsSql = "SELECT contact_id, contact_Naam, contact_Achternaam, contact_Email, contact_Status, contact_Bericht FROM contact WHERE contact_id = $contactId";
        $result = $conn->query($detailsSql);
        $contactDetails = $result->fetch_assoc();
 
        // Toon de details van het bericht
        if (!empty($contactDetails)) {
            if (!isset($_GET['contact_id'])) {
                echo '<div id="detailsContainer">';
                ?>
                <div class="details-item">
                    <hr>
                    Naam:<br><?php echo $contactDetails['contact_Naam'] . " " . $contactDetails['contact_Achternaam'] . '<br><br>'; ?>
                    E-mail:<br><span><?php echo $contactDetails['contact_Email']; ?></span>
                    <hr>
                    Bericht:<br><?php echo $contactDetails['contact_Bericht']; ?><br>
                    Status:<br><?php echo $contactDetails['contact_Status']; ?><br>
                </div>
                <?php
                echo '</div>';
            }
        } else {
            echo '<p>Bericht niet gevonden.</p>';
        }
 
        $updateStatusSql->close();
    } else {
        echo '<p>Ongeldige URL. Geen contact_id opgegeven.</p>';
    }
 
    ?>
 
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
 