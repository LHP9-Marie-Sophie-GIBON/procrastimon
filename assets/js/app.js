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
let toast = new bootstrap.Toast(toastElement, {
    keyboard: false
});
toast.show();


// MODAL FORMULAIRE
let openModal = new bootstrap.Modal(document.querySelector('.openModal'), {
    keyboard: false
})
openModal.show();// nous l'ouvrons avec la methode show()


console.log('Hello World !');
