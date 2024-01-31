<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('navbar-admin.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bestel-admin.css">
    <style>
        html, body {
            margin: 0;
            background: linear-gradient(rgb(0, 0, 0),rgb(140, 140, 140));
        }
        body {
            margin: 0;
            padding-bottom: 60px; /* Voeg padding toe aan de onderkant van de pagina, gelijk aan de hoogte van de footer */
            background: linear-gradient(rgb(0, 0, 0), rgb(140, 140, 140));
        }
        .recipe-container {
            border: 1px solid #ccc;
            border-radius: 3%;
            background-color: #e9e9e9;
            padding: 10px;
            margin: 10px;
            margin-top: 25px;
            display: inline-block;
            text-align: center;
            max-width: 100%;
            width: 280px;
            font-size: 15px;
        }

        .recipe-container img {
            max-width: 200px;
            height: 250px;
            width: 200px;
            max-height: 300px;
            margin-bottom: 10px;
        }

        a {
            color: white;
            text-decoration: none;
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
        .btn {
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #282A35;
            color: white;
            position: relative;
            text-decoration: none;
        }

        button:hover {
            background-color: #510909;
        }
        #applyDiscountBtn {
    background-color: #510909; /* Groene kleur */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#applyDiscountBtn:hover {
    background-color: red; /* Donkerdere groene kleur bij hover */
}

        .navbar-logo {
            background-color: white;
            background-image: url("logo hier");
            border-radius: 100%;
            width: 45px;
            height: 45px;
            margin-right: 0.5em;
            -webkit-border-radius: 100%;
            -moz-border-radius: 100%;
            -ms-border-radius: 100%;
            -o-border-radius: 100%;
        }

        * {
            font-family: "Raleway";
            box-sizing: border-box;
        }

        .top-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            background-color: black;
            color: #FFF;
            height: 50px;
            padding: 1em;
        }

        .menu {
            display: flex;
            flex-direction: row;
            row-gap: 1fr;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .menu > a {
            margin: 0 3rem;
            overflow: hidden;
        }

        .menu-button-container {
            display: none;
            height: 100%;
            width: 30px;
            cursor: pointer;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #menu-toggle {
            display: none;
        }

        .menu-button,
        .menu-button::before,
        .menu-button::after {
            display: block;
            background-color: white;
            position: absolute;
            height: 4px;
            width: 30px;
            transition: transform 400ms cubic-bezier(0.23, 1, 0.32, 1);
            border-radius: 2px;
        }

        .menu-button::before {
            content: '';
            margin-top: -8px;
        }

        .menu-button::after {
            content: '';
            margin-top: 8px;
        }

        #menu-toggle:checked + .menu-button-container .menu-button::before {
            margin-top: 0px;
            transform: rotate(405deg);
        }

        #menu-toggle:checked + .menu-button-container .menu-button {
            background: rgba(255, 255, 255, 0);
        }

        #menu-toggle:checked + .menu-button-container .menu-button::after {
            margin-top: 0px;
            transform: rotate(-405deg);
        }
        #icoons {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgb(0, 0, 0);
            height: 50px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-around;
            }
            
        .icoon {
            display: flex;
            align-items: center;
            color: white;
        }
            
        .icoon > p {
            margin: 0;
            padding-left: 5px; /* Adjust the padding as needed */
        }
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
        @media (max-width: 700px) {
            .menu-button-container {
                display: flex;
            }
            .menu {
                position: absolute;
                top: 0;
                margin-top: 50px;
                left: 0;
                flex-direction: column;
                width: 100%;
                justify-content: center;
                align-items: center;
                text-decoration: none;
            }
            #menu-toggle ~ .menu a {
                height: 0;
                margin: 0;
                padding: 0;
                border: 0;
                transition: height 400ms cubic-bezier(0.23, 1, 0.32, 1);
            }
            #menu-toggle:checked ~ .menu a {
                border: 1px solid #333;
                height: 2.5em;
                padding: 0.5em;
                transition: height 400ms cubic-bezier(0.23, 1, 0.32, 1);
            }
            .menu > a {
                display: flex;
                justify-content: center;
                margin: 0;
                padding: 0.5em 0;
                width: 100%;
                color: white;
                background-color: #222;
            }
            .menu > a:not(:last-child) {
                border-bottom: 1px solid #444;
            }
        }

        .menu a {
            text-decoration: none;
            color: white;
        }

        .dropdown-menu {
            z-index: 9999;
        }

        .slider {
            z-index: 2000;
        }

        .ul.menu {
            z-index: 9999;
        }

        .top-nav {
            position: relative;
            z-index: 1;
        }

        .slider {
            position: relative;
            z-index: 0;
        }

        /* Voeg andere stijlen hier toe indien nodig */
    </style>
    <title>Bestel pagina</title>
</head>

<body>
<?php
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['boek_id']) && isset($_POST['newPrice'])) {
        $boek_id = $_POST['boek_id'];
        $newPrice = $_POST['newPrice'];

        // Controleer of de nieuwe prijs gelijk is aan de oude prijs om de korting te verwijderen
        $checkOldPrice = "SELECT Boek_prijs FROM recepteboeken WHERE Boek_id = ?";
        $checkStmt = $conn->prepare($checkOldPrice);
        $checkStmt->bind_param("i", $boek_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $checkRow = $checkResult->fetch_assoc();
        $oldPrice = $checkRow['Boek_prijs'];

        if ($newPrice == $oldPrice) {
            // Korting verwijderen
            $updateSql = "UPDATE recepteboeken SET Korting_prijs = NULL, Status = NULL WHERE Boek_id = ?";
        } else {
            // Nieuwe korting toepassen
            $updateSql = "UPDATE recepteboeken SET Korting_prijs = ?, Status = 'korting' WHERE Boek_id = ?";
        }

        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("di", $newPrice, $boek_id);
        $stmt->execute();
    } elseif (isset($_POST['resetOriginal']) && isset($_POST['boekId'])) {
        // Herstel naar oude prijs
        $resetSql = "UPDATE recepteboeken SET Korting_prijs = NULL, Status = NULL WHERE Boek_id = ?";
        $resetStmt = $conn->prepare($resetSql);
        $resetStmt->bind_param("i", $_POST['boekId']);
        $resetStmt->execute();
    }
}

try {
    $sql = "SELECT * FROM recepteboeken";
    $result = $conn->query($sql);
    $boeken = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Er is iets fout gegaan met ophalen.";
}
?>

<?php foreach ($boeken as $boek) { ?>
    <div class="recipe-container">
        <div>
            <?php echo $boek['Boek_naam'] . '<br>'; ?>
            <?php if (!empty($boek['Boek_img'])) : ?>
                <img src="uploads/<?php echo $boek['Boek_img']; ?>" alt="<?php echo $boek['Boek_naam']; ?>" width="150"><br>
            <?php else : ?>
                Geen afbeelding beschikbaar<br>
            <?php endif; ?>
            <?php echo "€" . number_format($boek['Boek_prijs'], 2, ',', '.') . '<br>'; ?>

            <div id="overlay_<?php echo $boek['Boek_id']; ?>" class="overlay" style="display: none;">
                <div class="overlay-content">
                    <p><?php echo $boek['Status'] == 'korting' ? 'Nieuwe Prijs' : 'Verander de prijs:'; ?></p>
                    <input type="text" id="newPrice_<?php echo $boek['Boek_id']; ?>" placeholder="Nieuwe prijs">
                    <button class="applyDiscountBtn" onclick="applyDiscount(<?php echo $boek['Boek_id']; ?>)">Opslaan</button><br><br>
                </div>
            </div>
            <button class="btn" onclick="showOverlay(<?php echo $boek['Boek_id']; ?>)">
                <?php echo $boek['Status'] == 'korting' ? 'Nieuwe Prijs' : 'Korting geven'; ?>
            </button>

            <!-- Voeg deze button toe voor het herstellen van de oude prijs -->
            <button onclick="resetToOriginal(<?php echo $boek['Boek_id']; ?>)">Herstel naar oude prijs</button>
        </div>

        <div class="price-container">
            <span class="old-price">Oude prijs: €<?php echo number_format($boek['Boek_prijs'], 2, ',', '.'); ?></span><br>
            <?php if ($boek['Status'] == 'korting') : ?>
                <span class="discount">Korting: €<?php echo number_format($boek['Korting_prijs'], 2, ',', '.'); ?></span><br>
            <?php endif; ?>
        </div>
    </div>
<?php } ?>

<script>
    function showOverlay(boekId) {
        var overlay = document.getElementById('overlay_' + boekId);
        overlay.style.display = 'flex';
    }

    function applyDiscount(boekId) {
        var newPriceInput = document.getElementById('newPrice_' + boekId);
        var newPrice = parseFloat(newPriceInput.value.replace(',', '.')); // Converteer naar een decimaal getal

        // Sending the data to the server using AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Reload the page to reflect the changes
                location.reload();
            }
        };
        xhttp.open("POST", "bestel-admin.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("boek_id=" + boekId + "&newPrice=" + newPrice);
    }

    function resetToOriginal(boekId) {
        // Sending the data to the server using fetch API
        fetch('bestel-admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: "resetOriginal=true&boekId=" + boekId,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                console.error('Er is iets fout gegaan bij het herstellen van de oude prijs:', data.error);
            }
        })
        .catch(error => {
            console.error('Er is iets fout gegaan bij het verwerken van de aanvraag:', error);
        });
    }
</script>




<footer>
    <div id="icoons">
        <div class="icoon">
            <i class="bi bi-facebook"></i>
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
            </svg>
            <p>Volg ons op facebook</p>
        </div>
        <div class="icoon">
                <i class="bi bi-instagram"></i>
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                </svg>
                <p>Volg ons op instagram</p>
        </div>
        <div class="icoon">
                <i class="bi bi-person-circle"></i>
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <p>Neem contact met ons op</p>
        </div>
    </div>
    </footer>
</body>

</html>
