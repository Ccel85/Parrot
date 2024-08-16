//Fonction pour modifier le sujet du formulaire de contact pour demande info vehicule
document.addEventListener('DOMContentLoaded', function() {
  var infoButton = document.querySelector('.demandeInfo'); 

  if (infoButton) {
      infoButton.addEventListener('click', function() {
          var messageSubject = document.getElementById('{{ form.subject.vars.id }}');
          if (messageSubject) {
              messageSubject.value = 'Demande info véhicule';
          } else {
              console.error("L'élément avec l'ID '{{ form.subject.vars.id }}' n'a pas été trouvé.");
          }
      });
  } else {
      console.error("Le bouton avec la classe 'demandeInfo' n'a pas été trouvé.");
  }
});
