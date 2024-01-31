<?php
function performLogin($email, $password) {
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "ala_6";
 
    $conn = new mysqli($servername, $username, $db_password, $dbname);
 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `e-mail` = ? AND `Wachtwoord` = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        header("Location: Home-admin.php");
        exit();
    } else {
        return "Ongeldige inloggegevens. Probeer opnieuw.";
    }
 
    $stmt->close();
    $conn->close();
}
 
$loginMessage = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["e-mail"];
    $password = $_POST["wachtwoord"];
    $loginMessage = performLogin($email, $password);
}
?>
 
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Je Pagina Titel</title>
    <link rel="stylesheet" href="inloggen.css">
</head>
<body>
 

<div class="login-box">
    <h2>Login</h2>
    <form name="loginForm" method="post" action="" onsubmit="return validateForm()">
        <div class="user-box">
            <input type="text" name="e-mail" required>
            <label>Email</label>
        </div>
        <div class="user-box">
            <input type="password" name="wachtwoord" required>
            <label>Password</label>
        </div>
        <a href="#" onclick="document.forms['loginForm'].submit()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Submit
        </a>
    </form>
    <p><?php echo $loginMessage; ?></p>
</div>
</body>
</html>
