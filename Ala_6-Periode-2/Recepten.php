<?php
require_once 'dbconnect.php';
 
function updateNewStatusAfterWeek($conn)
{
    $oneWeekAgo = date('Y-m-d', strtotime('-1 week'));
    $sql = "UPDATE recepteboeken SET Nieuw_status = 0 WHERE Korting_startdatum <= '$oneWeekAgo'";
    $conn->query($sql);
}
 
function getReviewsForBook($conn, $bookId) {
    $sql = "SELECT user_name, user_review FROM recensies WHERE book_id = '$bookId'";
    $result = $conn->query($sql);
 
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}
 
function getDistinctCategories($conn)
{
    $sql = "SELECT DISTINCT Boek_Filter as category FROM recepteboeken";
    $result = $conn->query($sql);
 
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}
 
updateNewStatusAfterWeek($conn);
 
// Filter based on category
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$searchFilter = isset($_GET['search']) ? $_GET['search'] : '';
 
try {
    // Adjusted the SQL query to consider category and search filters
    $sql = "SELECT * FROM recepteboeken WHERE (Boek_Filter = '$categoryFilter' OR '$categoryFilter' = '') AND (Boek_naam LIKE '%$searchFilter%' OR '$searchFilter' = '')";
    $result = $conn->query($sql);
    $boeken = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Er is iets fout gegaan met ophalen.";
}
 
$categories = getDistinctCategories($conn); // Fetch distinct categories
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <?php include('navbar.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recepten-gebruiker.css">
    <title>Recepten</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        /* ... (Bestaande CSS-regels blijven hetzelfde) ... */
 
        /* Aangepaste CSS voor de recensie-overlay */
        #review-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
            padding: 20px;
            box-sizing: border-box;
            z-index: 1000; /* Zorg ervoor dat de overlay bovenop andere elementen ligt */
        }
 
        #review-text {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-sizing: border-box;
            max-width: 800px;
            margin: 0 auto;
        }
 
        .review-container {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
 
        #all-reviews {
            max-height: 60vh;
            overflow-y: auto;
        }
        #review-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    overflow: auto;
    padding: 20px;
    box-sizing: border-box;
    z-index: 1000; /* Zorg ervoor dat de overlay bovenop andere elementen ligt */
}
 
#review-text {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
    width: 1057px;
    margin: 0 auto;
    height: 1000px;
}
 
#review-text h2 {
    margin-bottom: 20px;
}
 
#user-name,
#user-review {
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 15px;
}
 
#user-review {
    height: 100px;  /* Voorkom dat het textarea-gebied te groot wordt */
    resize: none; /* Voorkom dat de gebruiker de grootte kan wijzigen */
}
 
#submit-review-btn {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #282A35;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
 
#submit-review-btn:hover {
    background-color: rgb(92, 19, 12); /* Donkere kleur bij hover */
}
 
#all-reviews {
    max-height: 60vh;
    overflow-y: auto;
}
 
 
    </style>
</head>
 
<body>
<form action="" method="get">
    <label for="category">Filter op categorie:</label>
    <select name="category" id="category">
        <option value="" <?php echo empty($categoryFilter) ? 'selected' : ''; ?>>Alle categorieën</option>
        <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category']; ?>" <?php echo $category['category'] === $categoryFilter ? 'selected' : ''; ?>><?php echo $category['category']; ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <button type="submit">Filter</button>
</form>
 
<?php foreach ($boeken as $boek) {
    $isNew = $boek['Nieuw_status'];
    $ribbonDisplay = $isNew ? 'block' : 'none';
    ?>
    <div class="recipe-container" data-book-id="<?php echo $boek['Boek_id']; ?>"
         data-ingredients="<?php echo htmlspecialchars($boek['ingredienten']); ?>"
         data-full-recipe="<?php echo htmlspecialchars($boek['Boek_recepten']); ?>"
         data-book-name="<?php echo htmlspecialchars($boek['Boek_naam']); ?>"
         data-reviews="<?php echo htmlspecialchars($boek['Recenties']); ?>">
        <div class="recipe-content">
            <span class="book-name"><?php echo $boek['Boek_naam']; ?></span><br>
            <?php if (!empty($boek['Boek_img'])) : ?>
                <img src="uploads/<?php echo $boek['Boek_img']; ?>" alt="<?php echo $boek['Boek_naam']; ?>" width="150"><br>
            <?php else : ?>
                Geen afbeelding beschikbaar<br>
            <?php endif; ?>
            <div><button class="btn more-info">Recept tonen<span class="ribbon" style="display: <?php echo $ribbonDisplay; ?>">NIEUW</span></button></div><br>
            <button class="btn write-review">Schrijf een recensie</button>
        </div>
        <div class="overlay-bg"></div>
    </div>
<?php } ?>
 
<!-- Toegevoegd gedeelte voor recensie-overlay -->
<div id="overlay" onclick="closeOverlay()">
    <div id="text">
        <span class="close-btn" onclick="closeOverlay()">X</span>
        <div id="recipe-details-content">
            <div id="slider-container">
                <div class="slider-tabs">
                    <div class="slider-tab active" data-tab="ingredients">Ingredienten</div>
                    <div class="slider-tab" data-tab="full-recipe">Volledig recept</div>
                    <div class="slider-tab" data-tab="reviews">Recensies</div>
                </div>
                <div class="slider-content">
                    <div id="ingredients-pane" class="slider-pane active"></div>
                    <div id="full-recipe-pane" class="slider-pane"></div>
                    <div id="reviews-pane" class="slider-pane">
                        <!-- Hier worden alle geschreven recensies weergegeven -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<div id="review-overlay">
    <div id="review-text">
        <span class="close-btn" onclick="closeReviewOverlay()">X</span>
        <h2>Schrijf een recensie</h2>
        <input type="hidden" id="book-id"> <!-- Verborgen veld om het boek-ID op te slaan -->
        <input type="text" id="user-name" placeholder="Je naam">
        <textarea id="user-review" placeholder="Schrijf hier je recensie"></textarea>
        <button id="submit-review-btn" type="button">Plaats recensie</button>
 
        <div id="all-reviews">
            <!-- Hier worden alle geschreven recensies weergegeven -->
        </div>
    </div>
</div>
<script src="jouw-javascript-bestand.js"></script>
<script>
    // JavaScript-code voor filterfunctionaliteit
 
// Wacht tot het document is geladen
document.addEventListener('DOMContentLoaded', function () {
    // Voeg een evenementenluisteraar toe aan het zoekveld
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function () {
        // Roep de functie aan om de boeken te filteren op basis van de zoekterm
        filterBooks(this.value.toLowerCase());
    });
});
 
// Functie om boeken te filteren op basis van zoekterm
function filterBooks(searchTerm) {
    // Selecteer alle boekencontainers
    const bookContainers = document.querySelectorAll('.recipe-container');
 
    // Itereer over elk boek en controleer of de zoekterm overeenkomt
    bookContainers.forEach(container => {
        const title = container.querySelector('.recipe-title').innerText.toLowerCase();
        const author = container.querySelector('.recipe-author').innerText.toLowerCase();
 
        // Controleer of de zoekterm overeenkomt met de titel of auteur
        if (title.includes(searchTerm) || author.includes(searchTerm)) {
            // Toon het boek als er een overeenkomst is
            container.style.display = 'block';
        } else {
            // Verberg het boek als er geen overeenkomst is
            container.style.display = 'none';
        }
    });
}
 
</script>
 
 
 
 
 
 
 
 
<!-- ... (Voet van de pagina blijft hetzelfde) ... -->
 
 
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