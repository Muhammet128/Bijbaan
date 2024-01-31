
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('navbar.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Home.css">
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Home.js" defer></script>
</head>
<body>


<div class="container">

    <section class="main-section">
        <h1 class="main-title">Kamadoing</h1>
        <p class="main-content">
        Welkom op de officiële website van Kamadoing!<br>
        Wij zijn verheugd u te verwelkomen in onze digitale ruimte,
        waar we een scala aan boeiende pagina's hebben samengesteld om aan de diverse behoeften van onze gewaardeerde klanten te voldoen.<br>
        Ontdek op onze 'Recepten' pagina een uitgebreide verzameling van heerlijke recepten. Hier vindt u niet alleen culinaire inspiratie,
        maar ook essentiële informatie over de bereidingstijd en andere relevante details.<br> <br> 
        Duik in de wereld van smaken en ontdek nieuwe en opwindende gerechten die uw kookervaring zullen verrijken.
        Op onze 'Bestellen' pagina bieden wij u de mogelijkheid om onze producten eenvoudig en snel te verkennen.
        Verken ons assortiment aan kookboeken en plaats uw bestelling gemakkelijk via bol.com.
        Ontdek de nieuwste en populairste culinaire publicaties die uw kookvaardigheden naar nieuwe hoogten zullen brengen.
        Last but not least, op onze 'Contact' pagina staan wij altijd voor u klaar.<
        Heeft u vragen, opmerkingen of problemen? Hier vindt u alle benodigde informatie om contact met ons op te nemen. xml_error_string
        Ons toegewijde team staat klaar om u te assisteren en uw ervaring met Kamadoing nog beter te maken.
        Neem de tijd om onze website te verkennen en laat u inspireren door de verscheidenheid aan mogelijkheden die Kamadoing te bieden heeft.
        Wij streven ernaar uw culinaire reis te verrijken en uw verwachtingen te overtreffen. Dank u wel voor uw bezoek!

        </p>
    </section>

    <div class="slideshow-container">
    <div class="mySlides fade">
        <img src="uploads/No-Worries-BBQ.jpg" style="width:60%">
    </div>

    <div class="mySlides fade">
        <img src="uploads/The-Best-OF-BBQ-Birds.jpg" style="width:60%">
    </div>

    <div class="mySlides fade">
        <img src="uploads/Fire-Food-friends-BBQ.jpg" style="width:60%">
    </div>
    </div>
</div>


<section  class="NieuwRecepten">
    <article>
        <h1 class="h1Recepten">Nieuwste recepten</h1>
    </article>
</section>
<?php
require_once 'dbconnect.php';
try {
// Add the LIMIT clause to restrict the result to 3 rows
$sql = "SELECT * FROM recepteboeken LIMIT 3";
$result = $conn->query($sql);
$boeken = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
echo "Er is iets fout gegaan met ophalen.";
}
?>

<?php foreach ($boeken as $boek) {
        $isNew = $boek['Nieuw_status'];
        $ribbonDisplay = $isNew ? 'block' : 'none';
    ?>
        <div class="recipe-container" data-book-id="<?php echo $boek['Boek_id']; ?>"
             data-ingredients="<?php echo htmlspecialchars($boek['ingredienten']); ?>"
             data-full-recipe="<?php echo htmlspecialchars($boek['Boek_recepten']); ?>"
             data-book-name="<?php echo htmlspecialchars($boek['Boek_naam']); ?>">
            <div class="recipe-content">
                <span class="book-name"><?php echo $boek['Boek_naam']; ?></span><br>
                <?php if (!empty($boek['Boek_img'])) : ?>
                    <img src="uploads/<?php echo $boek['Boek_img']; ?>" alt="<?php echo $boek['Boek_naam']; ?>" width="150"><br>
                <?php else : ?>
                    Geen afbeelding beschikbaar<br>
                <?php endif; ?>
            </div>
        </div>
    <?php } ?>
<?php
require_once 'dbconnect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get a random recipe
$query = "SELECT * FROM recepteboeken ORDER BY RAND() LIMIT 1";
$result = $conn->query($query);

// Fetch the result
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $recipeName = $row["Boek_naam"];
    $recipeContent = $row["Boek_recepten"];
    // You can fetch other fields as needed
} else {
    $recipeName = "No recipes found";
    $recipeContent = "";    
}

// Close the database connection
$conn->close();
?>  


<div class="receptenRandom">
    <button class="random-recipe-button" onclick="getRandomRecipe()">Veras me</button>
    <h2><?php echo $recipeName; ?></h2>
    <p><?php echo nl2br($recipeContent); ?></p>
</div>



</body>
</html>

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
