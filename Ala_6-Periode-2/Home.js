function getRandomRecipe() {
    // Reload the page to get a new random recipe
    location.reload();
}


let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}


function applyDiscount(boekId) {
    // Voeg hier de AJAX-implementatie toe om korting toe te passen op de server
    fetch('apply_discount.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ boekId: boekId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update de weergave van de prijs en andere gerelateerde elementen voor het specifieke boek
            const oldPriceElement = document.querySelector('.old-price[data-boek-id="' + boekId + '"]');
            const discountElement = document.querySelector('.discount[data-boek-id="' + boekId + '"]');
            const btnElement = document.querySelector('.btn[data-boek-id="' + boekId + '"]');
 
            oldPriceElement.style.display = 'none';
            discountElement.style.display = 'none';
            btnElement.removeAttribute('onclick');
            btnElement.innerText = 'Bestellen';
        } else {
            console.error('Er is iets fout gegaan bij het toepassen van korting.');
        }
    })
    .catch(error => {
        console.error('Er is iets fout gegaan bij het verwerken van de aanvraag:', error);
    });
}
 
document.addEventListener('DOMContentLoaded', function () {
    const recipeContainers = document.querySelectorAll('.recipe-container');
 
    recipeContainers.forEach(container => {
        const ingredients = container.dataset.ingredients;
        const formattedIngredients = formatText(ingredients);
 
        const fullRecipe = container.dataset.fullRecipe;
        const formattedFullRecipe = formatText(fullRecipe);
 
        const reviews = container.dataset.reviews;
        const formattedReviews = formatText(reviews);
 
        const popupContent = `
            <div class="popup-content">
                <h2>${container.dataset.bookName}</h2>
                <div class="ingredients-and-recipe">
                    <div class="ingredients-pane">
                        <h3>Ingrediënten:</h3>
                        <p>${formattedIngredients}</p>
                    </div>
                    <div class="recipe-pane">
                        <h3>Bereiding:</h3>
                        <p>${formattedFullRecipe}</p>
                    </div>
                    <div class="reviews-pane">
                        <h3>Recensies:</h3>
                        <div class="all-reviews-popup">${formattedReviews}</div>
                    </div>
                </div>
            </div>
        `;
 
        container.querySelector('.more-info').addEventListener('click', function () {
            document.querySelector('#text').innerHTML = popupContent;
            document.querySelector('.overlay-bg').style.display = 'block';
            document.querySelector('#overlay').style.display = 'flex';
            document.querySelector('.all-reviews-popup').innerHTML = formattedReviews;
        });
 
        container.querySelector('.write-review').addEventListener('click', function () {
            document.querySelector('#review-overlay').style.display = 'flex';
            document.getElementById('book-id').value = container.dataset.bookId;
            loadExistingAndNewReviews(container.dataset.bookId);
        });
    });
 
    function formatText(text) {
        const lines = text.split('\n');
        const formattedText = lines.map(line => line.trim()).join('<br>');
        return formattedText;
    }
 
    function loadExistingAndNewReviews(bookId) {
        fetch('get_reviews.php?book_id=' + bookId)
            .then(response => response.json())
            .then(data => {
                const allReviewsContainer = document.querySelector('#all-reviews');
                if (allReviewsContainer) {
                    allReviewsContainer.innerHTML = '';
 
                    data.forEach(review => {
                        const reviewContainer = document.createElement('div');
                        reviewContainer.className = 'review-container';
                        reviewContainer.innerHTML = `<strong>${review.user_name}:</strong> ${review.user_review}`;
                        allReviewsContainer.appendChild(reviewContainer);
                    });
                }
            })
            .catch(error => {
                console.error('Er is een fout opgetreden bij het ophalen van recensies:', error);
            });
    }
 
    function addReviewToContainer(userName, userReview) {
        const allReviewsContainer = document.querySelector('#all-reviews');
        if (allReviewsContainer) {
            const reviewContainer = document.createElement('div');
            reviewContainer.className = 'review-container';
            reviewContainer.innerHTML = `<strong>${userName}:</strong> ${userReview}`;
            allReviewsContainer.appendChild(reviewContainer);
        }
    }
 
    function closeReviewOverlay() {
        document.querySelector('#review-overlay').style.display = 'none';
    }
 
    function submitReview() {
        const bookId = document.getElementById('book-id').value;
        const userName = document.getElementById('user-name').value;
        const userReview = document.getElementById('user-review').value;
 
        if (userName && userReview) {
            addReviewToContainer(userName, userReview);
            saveReviewToDatabase(bookId, userName, userReview);
        } else {
            alert('Vul zowel je naam als je recensie in.');
        }
    }
 
    function saveReviewToDatabase(bookId, userName, userReview) {
        fetch('save_review.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `book_id=${bookId}&user_name=${userName}&user_review=${userReview}`,
        })
            .then(response => response.json())
            .then(data => {
                console.log('Recensie succesvol opgeslagen in de database:', data);
            })
            .catch(error => {
                console.error('Er is een fout opgetreden bij het opslaan van de recensie:', error);
            });
    }
 
    document.querySelector('#review-overlay button').addEventListener('click', function () {
        submitReview();
    });
 
    document.querySelector('#overlay').addEventListener('click', function () {
        document.querySelector('.overlay-bg').style.display = 'none';
        document.querySelector('#overlay').style.display = 'none';
    });
 
    document.querySelector('#review-overlay .close-btn').addEventListener('click', function () {
        closeReviewOverlay();
    });
}); 