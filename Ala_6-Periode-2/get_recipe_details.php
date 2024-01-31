<?php
// get_recipe_details.php

require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Book_Id"])) {
    $bookId = $_POST["Book_Id"];

    // Selecteer de juiste kolommen in je SQL-query
    $sql = "SELECT Boek_id, Boek_naam, Boek_img, Boek_prijs, Recept_img, Boek_recepten FROM recepteboeken WHERE Boek_id = $bookId";
    $result = $conn->query($sql);

    if ($result) {
        $recipeDetails = $result->fetch_assoc();

        // Stuur de receptinformatie terug als JSON
        echo json_encode($recipeDetails);
    } else {
        echo "Er is iets fout gegaan bij het ophalen van de receptinformatie.";
    }
} else {
    echo "Ongeldig verzoek.";
}
?>
