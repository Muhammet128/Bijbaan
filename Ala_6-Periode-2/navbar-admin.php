<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Navbar-admin-2.css">
</head>
<body>
    



<header>
    <section class="top-nav">
        <div>
        <img id="navbar-logo" src="uploads/Logo_Ala.png" width="50px">
        </div>
       
        <label class='menu-button-container' for="menu-toggle">
            <div class='menu-button'></div>
        </label>

        <ul class="menu">
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: white">Home
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="Home.php" style="color: black">Home</a>
                    <a href="Home-admin.php" style="color: black">Home-admin</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: white">Recepten
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="Recepten.php" style="color: black">Recepten</a>
                    <a href="Recepten-toevoegen.php" style="color: black">Recepten-admin</a>
                    <a href="Recept-bewerken.php" style="color: black">Recept-bewerken</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: white">Bestellen
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="Bestel.php" style="color: black">Bestellen</a>
                    <a href="Bestel-admin.php" style="color: black">Bestellen-admin</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: white">Contact
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="Contact.php" style="color: black">Contact</a>
                    <a href="Contacten-admin.php" style="color: black">Contact-admin</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: white">Inloggen/Registreren
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="inloggen.php" style="color: black">Inloggen</a>
                    <a href="Register.php" style="color: black">Registreren</a>
                </div>
            </li>
        </ul>
    </section>
</header>
</body>
</html>