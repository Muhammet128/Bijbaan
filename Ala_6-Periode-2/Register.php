<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ala_6";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
$registrationMessage = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["e-mail"];
    $wachtwoord = $_POST["wachtwoord"];
    $naam = $_POST["naam"];
    $achternaam = $_POST["achternaam"];
 
    // Check for empty fields
    if (empty($naam) || empty($achternaam) || empty($email) || empty($wachtwoord)) {
        $registrationMessage = "Vul alle verplichte velden in.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registrationMessage = "Ongeldig e-mailadres. Voer een geldig e-mailadres in.";
    } else {
        $check_stmt = $conn->prepare("SELECT `e-mail` FROM `admin` WHERE `e-mail` = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
 
        if ($check_result->num_rows > 0) {
            $registrationMessage = "Dit e-mailadres is al geregistreerd. Gebruik een ander e-mailadres.";
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO `admin` (`e-mail`, `Wachtwoord`, `Naam`, `Achternaam`) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $email, $wachtwoord, $naam, $achternaam);
 
            if ($insert_stmt->execute()) {
                $registrationMessage = "Registratie succesvol!";
                header("Location: inloggen.php");
            } else {
                $registrationMessage = "Registratie mislukt. Probeer opnieuw.";
            }
        }
    }
}
 
$conn->close();
?>
 
<!DOCTYPE html>
<html lang="nl">
<head>
    <?php include('navbar-admin.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Je Pagina Titel</title>
    <link rel="stylesheet" href="inloggen.css">
    <script>
        function validateForm() {
            var email = document.forms["loginForm"]["e-mail"].value;
 
            if (email.indexOf('@') === -1) {
                alert("Ongeldig e-mailadres. Voer een geldig e-mailadres in.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
  
<div class="login-box">
    <h2>Registratie</h2>
    <form name="loginForm" method="post" action="" onsubmit="return validateForm()">
        <div class="user-box">
            <input type="text" name="naam" required>
            <label>Naam</label>
        </div>
        <div class="user-box">
            <input type="text" name="achternaam" required>
            <label>Achternaam</label>
        </div>
        <div class="user-box">
            <input type="text" name="e-mail" required>
            <label>Email</label>
        </div>
        <div class="user-box">
            <input type="password" name="wachtwoord" required>
            <label>Wachtwoord</label>
        </div>
        <a href="#" onclick="document.forms['loginForm'].submit()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Registreren
        </a>
    </form>
    <p><?php echo $registrationMessage; ?></p>
</div>
</body>
</html>