// const form = document.querySelector('#formGoal');

// form.addEventListener('submit', function(event) {
//     event.preventDefault(); // empêcher le comportement par défaut du formulaire

//     // récupérer les données du formulaire
//     var formData = new FormData(event.target);
//     var formAction = event.target.action;

//     // envoyer la requête AJAX
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', formAction);
//     xhr.onload = function() {
//         if (xhr.status === 200) {
//             // la requête a réussi, faire quelque chose avec la réponse
//             console.log(xhr.responseText);
//         } else {
//             // la requête a échoué, afficher une erreur
//             console.error('Erreur: ' + xhr.statusText);
//         }
//     };
//     xhr.send(formData);
// });
