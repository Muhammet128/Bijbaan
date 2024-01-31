<!DOCTYPE html>
<html lang="en">
 
<head>
    <?php include('navbar-admin.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recepten-admin.css">
    <title>Recepten toevoegen</title>
</head>
 
<body>
 
    <?php
    require_once 'dbconnect.php';
 
    // Controleer of het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
 
        // Controleer of vereiste velden niet leeg zijn
        if (isset($_FILES["boek_img"]) && !empty($_POST['boek_naam']) && !empty($_POST['boek_prijs']) && !empty($_POST['boek_link']) && !empty($_POST['boek_recepten']) && !empty($_POST['Ingredienten']) && isset($_POST['boek_filter'])) {
            $uploadDir = __DIR__ . "/uploads/";
            $targetFile = $uploadDir . basename($_FILES["boek_img"]["name"]);
 
            // Check if file is an actual image
            $check = getimagesize($_FILES["boek_img"]["tmp_name"]);
            if ($check === false) {
                echo "Bestand is geen afbeelding.";
            } else {
                // Ensure the 'uploads' directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
 
                // Move the uploaded file to the destination
                if (move_uploaded_file($_FILES["boek_img"]["tmp_name"], $targetFile)) {
                    // Ontvang de overige ingevoerde gegevens, inclusief het vegetarische aspect
                    $boek_naam = $_POST['boek_naam'];
                    $boek_prijs = $_POST['boek_prijs'];
                    $boek_link = $_POST['boek_link'];
                    $boek_recepten = $_POST['boek_recepten'];
                    $Ingredienten = $_POST['Ingredienten'];
                    $boek_filter = $_POST['boek_filter']; // Nieuw veld voor vegetarisch aspect
 
                    // Voeg de gegevens toe aan de database
                    $filename = basename($_FILES["boek_img"]["name"]);
                    $conn->query("INSERT INTO recepteboeken (Boek_naam, Boek_prijs, Boek_link, Boek_recepten, Ingredienten, Boek_img, Boek_filter)
                                  VALUES ('$boek_naam', '$boek_prijs', '$boek_link', '$boek_recepten', '$Ingredienten', '$filename', '$boek_filter')");
 
                    // Doe een omleiding (redirect) om een nieuwe GET-aanvraag naar de pagina te doen
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo "Sorry, er was een probleem met het uploaden van je bestand.";
                }
            }
        }
    }
    ?>
 
    <!-- Formulier om een nieuw receptenboek toe te voegen -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="boek_naam">Naam van het receptenboek:</label>
        <input type="text" name="boek_naam" required><br>
 
        <label for="boek_prijs">Prijs:</label>
        <input type="text" name="boek_prijs" required><br>
 
        <label for="boek_link">Link:</label>
        <input type="text" name="boek_link" required><br>
 
        <label for="Ingredienten">Ingredienten:</label>
        <textarea name="Ingredienten" rows="4" required></textarea><br>
 
        <label for="boek_recepten">Recepten:</label>
        <textarea name="boek_recepten" rows="4" required></textarea><br>
 
        <label for="boek_img">Afbeelding:</label>
        <input type="file" name="boek_img" id="boek_img" required><br>
            
        <label for="boek_filter">Vegetarisch:</label>
        <select name="boek_filter" required>
            <option value="geen_vega">Niet vegetarisch</option>
            <option value="Vega">Vegetarisch</option>
        </select><br><br>
 
        <input type="submit" name="submit" value="Toevoegen aan de database">
    </form>
 
</body>
 
</html>
 