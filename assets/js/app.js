// INTERACTION PROCRASTIMON
let procrastimon = document.querySelector('#myProcrastimon');
let countClick = 0;

function changeMood() {
    countClick++;
    console.log(countClick);
    if (countClick >= 5) {
        getAngry();
        setTimeout(() => countClick = 0, 15000);
    } else {
        getHappy();
    }
}

function getHappy() {
    procrastimon.src = happySprite;
    procrastimon.classList.add('happy');
    setTimeout(function () {
        procrastimon.classList.remove('happy');
        procrastimon.src = regularSprite;
    }, 3000);

}

function getAngry() {
    procrastimon.src = angrySprite;
    procrastimon.classList.add('angry');
    setTimeout(function () {
        procrastimon.classList.remove('angry');
        procrastimon.src = regularSprite;
    }, 5000);
}


// LOADER
const loader = document.querySelector('.loader-container');
const backdrop = document.querySelector('.backdrop');

window.addEventListener('load', () => {
    setTimeout(() => {
        loader.style.display = 'none';
        backdrop.classList.remove('show');
        backdrop.classList.add('hide'); // Ajoute la classe "hide" pour cacher le backdrop une fois le chargement terminé
    }, 400);

});

backdrop.classList.add('show'); // Ajoute la classe "show" pour faire apparaître le backdrop en même temps que le loader


function disableLoader() { // fonction pour désactiver le loader
    loader.style.display = 'none';
    backdrop.classList.remove('show');
    backdrop.classList.add('hide');
}

// LEVEL UP
const lvlbackdrop = document.querySelector('#levelupBackdrop');
const levelUp = document.querySelector('#levelupLoader');
levelUp.style.display = 'none';
lvlbackdrop.classList.add('hide');

function letsEvolve() {
    // Cacher le loader principal
    disableLoader();

    // Afficher le loader de level up
    levelUp.style.display = 'block';
    lvlbackdrop.classList.remove('hide'); 
    lvlbackdrop.classList.add('show');

    setTimeout(() => {
        levelUp.style.display = 'none';
        lvlbackdrop.classList.remove('show');
        lvlbackdrop.classList.add('hide');      
    }, 3500);

}



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


