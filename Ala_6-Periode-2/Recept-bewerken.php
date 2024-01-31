<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('navbar-admin.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Recepten-bewerken.css">
    <title>Recepten Bewerken</title>
    <style>
        .strikethrough {
            text-decoration: line-through;
        }

        .discount {
            font-size: 18px;
            color: red;
        }

        .ribbon {
            width: 60px;
            font-size: 14px;
            padding: 4px;
            position: absolute;
            right: -25px;
            top: -12px;
            text-align: center;
            border-radius: 25px;
            transform: rotate(20deg);
            background-color: #ff0000;
            color: white;
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            color: white;
            padding: 1em;
        }

        .menu {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .menu a {
            display: inline-block;
            vertical-align: top;
            padding: 14px 16px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: red;
            border: 1px solid red; /* Add border on hover */
        }

        .dropdown {
            position: relative;
            display: inline-block;
            color: white;
           
        }

        .dropbtn {
            font-size: 17px;
            border: none;
            outline: none;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            color: white;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            border-radius: 10px;
            z-index: 1;
        }

        .dropdown-content a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            text-align: left;
            color: white;
        }

        .dropdown-content a:hover {
            background-color: grey;
            border: 1px solid grey; /* Add border on hover */
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        </style>

</head>
<body>


    <div class="recipe-edit-container">
        <h2>Recepten Bewerken</h2>

        <!-- Formulier om recepten te bewerken -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="boek-id">Boek ID:</label>
            <input type="text" id="boek-id" name="boek_id" required>

            <label for="nieuwe-naam">Nieuwe Naam:</label>
            <input type="text" id="nieuwe-naam" name="nieuwe_naam" required>

            <label for="boek_link">Link:</label>
        <input type="text" name="boek_link" required><br>

            <label for="nieuwe-tekst">Nieuwe Tekst:</label>
            <textarea id="nieuwe-tekst" name="nieuwe_tekst" rows="4" required></textarea>

            <label for="boek-img">Boek Afbeelding:</label>
            <input type="file" id="boek-img" name="boek_img" accept="image/*" required>

            <input type="submit" value="Bewerken">
        </form>
    </div>
</body>
</html>


<?php
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $boekId = $_POST["boek_id"];
    $nieuweNaam = $_POST["nieuwe_naam"];
    $boek_link = $_POST["boek_link"];
    $nieuweTekst = $_POST["nieuwe_tekst"];

    // Uploaden van Boek_img
    $boekImg = $_FILES["boek_img"]["name"];
    $boekImgTmp = $_FILES["boek_img"]["tmp_name"];
    $boekImgPath = "uploads/" . $boekImg;
    move_uploaded_file($boekImgTmp, $boekImgPath);


    // Voer een update-query uit om het recept bij te werken
    $updateQuery = "UPDATE recepteboeken SET Boek_naam = '$nieuweNaam', Boek_link = '$boek_link', Boek_recepten = '$nieuweTekst', Boek_img = '$boekImg' WHERE Boek_id = $boekId";


    if ($conn->query($updateQuery) === TRUE) {
        echo "Recept succesvol bijgewerkt.";
    } else {
        echo "Fout bij het bijwerken van het recept: " . $conn->error;
    }
}

// Haal de bestaande recepten op uit de database
try {
    $sql = "SELECT * FROM recepten";
    $result = $conn->query($sql);
    $recepten = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Er is iets fout gegaan met ophalen van recepten.";
}
?>


