// Définition de la fonction pour afficher les étoiles en fonction du nombre donné
function afficherEtoiles(nombre) {
  var etoiles = '';
  for (var i = 0; i < nombre; i++) {
      etoiles += '★'; // Ajoute une étoile à chaque itération
  }
  return etoiles;
}

document.addEventListener("DOMContentLoaded", function() {
  // Sélectionnez tous les éléments ayant la classe "rating"
  var ratings = document.querySelectorAll('.rating');
  // Pour chaque élément, convertissez la valeur en étoiles
  ratings.forEach(function(ratingElement) {
      var rating = parseInt(ratingElement.dataset.rating); // Convertit le contenu en nombre
      var etoiles = afficherEtoiles(rating); // Convertit le nombre en étoiles en utilisant la fonction définie ci-dessus
      var etoilesContainer = ratingElement.nextElementSibling; // Sélectionne l'élément suivant (qui est le conteneur des étoiles)
      etoilesContainer.textContent = etoiles; // Affiche les étoiles dans le conteneur
  });
});