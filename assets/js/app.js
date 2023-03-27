// TOOLTIPS
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// PROGRESS BAR HP
const progressBar = document.querySelector('.progress-bar.barPV');
console.log(progressBar.style.width);

if (parseFloat(progressBar.style.width) >= 26 && parseFloat(progressBar.style.width) <= 50) {
    if (!progressBar.classList.contains('hp50')) {
        progressBar.classList.add('hp50');
        console.log('Added hp50 class');
    } else {
        console.log('hp50 class already present');
    }

} else if (parseFloat(progressBar.style.width) >= 0 && parseFloat(progressBar.style.width) <= 25) {
    if (!progressBar.classList.contains('hp25')) {
        progressBar.classList.add('hp25');
        console.log('Added hp25 class');
    } else {
        console.log('hp25 class already present');
    }
}

// TOASTS
let toastElement = document.querySelector('.toast.openToast');
if (toastElement) {
  let toast = new bootstrap.Toast(toastElement, {
    keyboard: false
  });
  toast.show();
}


// MODAL FORMULAIRE
let openModalElement = document.querySelector('.openModal');
if (openModalElement) { // si openModalElement est trouvé
    let openModal = new bootstrap.Modal(openModalElement, {
        keyboard: false
    });
    openModal.show(); // nous l'ouvrons avec la methode show()
}

// CAROUSEL GAMEOVER ENDGAME
var carousel = document.querySelector('#carousel-gameover');

// Ajouter un écouteur d'événements sur le carousel
if (carousel) {
    carousel.addEventListener('slide.bs.carousel', function (event) {
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
}


