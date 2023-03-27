// CAROUSEL GAMEOVER ENDGAME
var carousel = document.querySelector('#carousel-gameover');

// Ajouter un écouteur d'événements sur le carousel
carousel.addEventListener('slide.bs.carousel', function(event) {
    console.log('woop');

    // Récupérer l'index de la slide active et le nombre total de slides
    var activeIndex = event.to;
    var totalSlides = this.querySelectorAll('.carousel-item').length;

    // Vérifier si la slide active est la dernière slide
    if (activeIndex == (totalSlides - 1)) {

        // rendre le bouton next visually hidden
        var nextButton = document.querySelector('#next');
        nextButton.classList.add('visually-hidden');
    }
});