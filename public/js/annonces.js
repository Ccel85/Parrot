//CARS
  //** Fonction pour afficher la valeur actuelle du curseur
  function afficherValeur(idSlider, idSpan) {
    var slider = document.getElementById(idSlider);
    var span = document.getElementById(idSpan);
  span.innerHTML = slider.value  ;
  }
//**Fonction appelée lors de la modification du curseur de prix
function updatePrixValue() {
// Récupérer la valeur du curseur de prix
var prixValue = document.getElementById('prix').value;
// Mettre à jour le contenu de l'élément span avec la valeur du curseur
document.getElementById('prixValeur').innerText = prixValue + ' €';
}
// Fonction pour filtrer les véhicules en fonction du prix
function getFilteredVehicles(prixValue,anneeValue,kmValue) {
// Sélectionner toutes les cartes (ou éléments) que vous souhaitez filtrer
const cards = document.querySelectorAll('.card');
// Parcourir toutes les cartes et filtrer en fonction du prix
cards.forEach(function(card) {
    // Récupérer le prix de la carte à partir de l'élément .prix
    var cardPrice = parseInt(card.querySelector('.prix').innerText);
    var cardAnnee = parseInt(card.querySelector('.year').innerText);
    var cardKm = parseInt(card.querySelector('.km').innerText);
    // Vérifier si le prix de la carte est inférieur ou égal à la valeur du curseur de prix
    if (cardPrice <= (prixValue+1)) {
      if (cardAnnee <= (anneeValue+1) && cardKm <= (kmValue+1)) {
        // Afficher la carte si elle correspond au critère de filtrage
        card.style.display = 'block';
    } else {
        // Masquer la carte si elle ne correspond pas au critère de filtrage
        card.style.display = 'none';
    }
};
})
}
document.addEventListener("DOMContentLoaded", function () {
  function afficherValeur(sliderId, displayId) {
      var slider = document.getElementById(sliderId);
      var display = document.getElementById(displayId);
      display.textContent = slider.value;
  }

  function getFilteredVehicles(prix, annee, km) {
      // Implementation for filtering vehicles based on slider values
      console.log('Filtering vehicles with:', { prix, annee, km });
      // Add your AJAX or filtering logic here
  }

  // Initialize display values
  afficherValeur("prix", "prixValeur");
  afficherValeur("annee", "anneeValeur");
  afficherValeur("km", "kmValeur");

  // Add event listeners for sliders
  document.getElementById("prix").addEventListener("input", function () {
      afficherValeur("prix", "prixValeur");
      getFilteredVehicles(
          parseInt(document.getElementById("prix").value),
          parseInt(document.getElementById("annee").value),
          parseInt(document.getElementById("km").value)
      );
  });

  document.getElementById("annee").addEventListener("input", function () {
      afficherValeur("annee", "anneeValeur");
      getFilteredVehicles(
          parseInt(document.getElementById("prix").value),
          parseInt(document.getElementById("annee").value),
          parseInt(document.getElementById("km").value)
      );
  });

  document.getElementById("km").addEventListener("input", function () {
      afficherValeur("km", "kmValeur");
      getFilteredVehicles(
          parseInt(document.getElementById("prix").value),
          parseInt(document.getElementById("annee").value),
          parseInt(document.getElementById("km").value)
      );
  });
});
//CARS DETAIL
//**affichage des annonce en detail apres clic sur le bouton PLUS DE DETAIL
document.addEventListener('DOMContentLoaded', function () {
    // Sélectionnez tous les boutons avec la classe 'button-occasions'
    var buttons = document.querySelectorAll('.button-occasions');
    // Ajoutez un gestionnaire d'événements pour chaque bouton
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Récupérez la valeur du bouton (l'ID de la voiture)
            var carId = button.value;
            // Redirection vers carDetail.php avec l'ID comme paramètre
            location.href = '../templates/carDetail.php?id=' + carId;
        });
    });
});

//Fonction pour modifier le sujet du formulaire de contact pour demande info vehicule
document.addEventListener('DOMContentLoaded', function() {
// Sélectionnez le bouton "Demande d'info"
var infoButton = document.querySelector('.demandeInfo'); 

// Ajoutez un gestionnaire d'événements au clic sur le bouton
infoButton.addEventListener('click', function() {
    // Créez un formulaire temporaire
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '../templates/contact.php';

    // Ajoutez un champ de formulaire pour le sujet
    var subjectInput = document.createElement('input');
    subjectInput.type = 'hidden';
    subjectInput.name = 'subject';
    subjectInput.value = 'Demande info véhicule';

    // Ajoutez le champ de formulaire au formulaire
    form.appendChild(subjectInput);

    // Ajoutez le formulaire à la page et soumettez-le
    document.body.appendChild(form);
    form.submit();
});
});