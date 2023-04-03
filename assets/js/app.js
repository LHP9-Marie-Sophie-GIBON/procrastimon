// musique de fond 
var audio = new Audio(
    "../assets/music/soundtrack.mp3"
);
let muteButton = document.querySelector('#mute-button')

function playMusic() {
// Vérifie si la lecture automatique est autorisée
const playPromise = audio.play();
    if (playPromise !== undefined) {
        playPromise.then(_ => {
            // La lecture a démarré avec succès
        })
            .catch(error => {
                document.addEventListener('click', () => {
                    audio.play();
                });
            });
    }
}


// Ajoute un événement de clic au bouton mute
muteButton.addEventListener('click', () => {
    // Vérifie si le son est activé ou désactivé
    if (audio.muted ) {
        // Active le son
        audio.play();
        audio.muted = false;
        muteButton.innerHTML = '<img src="https://img.icons8.com/external-tal-revivo-bold-tal-revivo/15/FFFFFF/external-volume-muted-with-a-crossed-sign-logotype-music-bold-tal-revivo.png"/>';
    } else {
        // Désactive le son
        audio.pause();
        audio.muted = true;
        muteButton.innerHTML = '<img src="https://img.icons8.com/ios-glyphs/18/FFFFFF/musical-notes.png"/>';
    }
});

// INTERACTION PROCRASTIMON
var happySound = new Audio(
    "../assets/music/happy.mp3"
);

var angrySound = new Audio(
    "../assets/music/angry.mp3"
);
var levelUpSound = new Audio(
    "../assets/music/levelup.mp3"
);


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
    happySound.play();
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
    angrySound.play();
    setTimeout(function () {
        procrastimon.classList.remove('angry');
        procrastimon.src = regularSprite;
    }, 5000);
}


// LOADER
const loader = document.querySelector('.loader-container');
const backdrop = document.querySelector('.backdrop');

if (loader) {
    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.style.display = 'none';
            backdrop.classList.remove('show');
            backdrop.classList.add('hide'); // Ajoute la classe "hide" pour cacher le backdrop une fois le chargement terminé
        }, 400);

    });

    backdrop.classList.add('show'); // Ajoute la classe "show" pour faire apparaître le backdrop en même temps que le loader
}




function disableLoader() { // fonction pour désactiver le loader
    loader.style.display = 'none';
    backdrop.classList.remove('show');
    backdrop.classList.add('hide');
}


// TOOLTIPS
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// PROGRESS BAR HP
const progressBar = document.querySelector('.progress-bar.barPV');
if (progressBar) {
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

// LEVEL UP
const lvlbackdrop = document.querySelector('#levelupBackdrop');
const levelUp = document.querySelector('#levelupLoader');
if (levelUp) {
    levelUp.style.display = 'none';
    lvlbackdrop.classList.add('hide');
}

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


