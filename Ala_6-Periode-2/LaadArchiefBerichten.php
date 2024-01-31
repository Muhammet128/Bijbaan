<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LaadArchiefBerichten.css">
    <title>ToonArchief</title>
</head>
<body>
   
</body>
</html>
<?php
require_once 'dbconnect.php';
 
try {
    $archiefSql = "SELECT contact_id, contact_Naam, contact_Achternaam, contact_Email, contact_Status, contact_Bericht, verwijderd FROM contact WHERE verwijderd = 1 ORDER BY contact_id DESC";
    $result = $conn->query($archiefSql);
    $archiefContacten = $result->fetch_all(MYSQLI_ASSOC);
 
    if (!empty($archiefContacten)) {
        foreach ($archiefContacten as $archiefContact) {
            ?>
            <div class="Archief-item">
                <hr>
                Contact ID:<?php echo $archiefContact['contact_id'] . '<br><br>'; ?>
                Naam:<?php echo $archiefContact['contact_Naam'] . " " . $archiefContact['contact_Achternaam'] . '<br><br>'; ?>
                E-mail:<span><?php echo $archiefContact['contact_Email']; ?></span>
                <hr>
                Bericht:<br><?php echo $archiefContact['contact_Bericht']; ?><br>
                <form action="Herstel.php" method="post">
                    <input type="hidden" name="contactId" value="<?php echo $archiefContact['contact_id']; ?>">
                    <button type="submit" class="restore-button">Herstellen</button>
                </form>
                <form action="Definitief-Verwijderen.php" method="post">
                    <input type="hidden" name="contactId" value="<?php echo $archiefContact['contact_id']; ?>">
                </form>
 
   
            </div>
            <?php
        }
    } else {
        echo '<p>Geen gearchiveerde berichten gevonden.</p>';
    }
} catch (Exception $e) {
    echo "Er is iets fout gegaan met ophalen van gearchiveerde berichten.";
}
?>