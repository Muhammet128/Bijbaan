<?php
require_once 'dbconnect.php';
 
try {
    $sql = "SELECT contact_id, contact_Naam, contact_Achternaam, contact_Email, contact_Status, contact_Bericht FROM contact ORDER BY contact_id DESC";
    $result = $conn->query($sql);
    $contacten = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Er is iets fout gegaan met ophalen.";
}
 
if (!empty($contacten)) {
    echo '<div id="contactenContainer">';
    foreach ($contacten as $contact) {
        ?>
        <a href="details.php?contact_id=<?php echo $contact['contact_id']; ?>" class="Contacten-container">
            <div class="contact-item" data-status="<?php echo $contact['contact_Status']; ?>">
                <hr>
                Naam:<br><?php echo $contact['contact_Naam'] . " " . $contact['contact_Achternaam'] . '<br><br>'; ?>
                E-mail:<br><span><?php echo $contact['contact_Email']; ?></span>
                <hr>
            </div>
        </a>
        <?php
    }
    echo '</div>';
} else {
    echo '<p>Geen contacten gevonden.</p>';
}
?>