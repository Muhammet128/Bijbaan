<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin-contact.css">
    <title>Archief</title>
</head>
<body>
   
</body>
</html>
 
<?php
require_once 'dbconnect.php';
 
try {
    // Selecteer alle verwijderde berichten (verwijderd = 1)
    $sql = "SELECT contact_id, contact_Naam, contact_Achternaam, contact_Email, contact_Bericht, contact_Status FROM contact WHERE verwijderd = 1 ORDER BY contact_id DESC";
    $result = $conn->query($sql);
    $verwijderdeContacten = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Er is iets fout gegaan met ophalen.";
}
 
if (!empty($verwijderdeContacten)) {
    echo '<div id="contactenContainer">';
    foreach ($verwijderdeContacten as $verwijderdContact) {
        ?>
        <a href="LaadArchiefBerichten.php?contact_id=<?php echo $verwijderdContact['contact_id']; ?>" class="Contacten-container">
            <div class="contact-item" data-status="<?php echo $verwijderdContact['contact_Status']; ?>">
                <hr>
                Naam:<br><?php echo $verwijderdContact['contact_Naam'] . " " . $verwijderdContact['contact_Achternaam'] . '<br><br>'; ?>
                E-mail:<br><span><?php echo $verwijderdContact['contact_Email']; ?></span>
                <hr>
            </div>
        </a>
        <?php
    }
    echo '</div>';
} else {
    echo '<p>Geen verwijderde contacten gevonden.</p>';
}
?>
 