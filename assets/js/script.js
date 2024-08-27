    
    //fonction filtre les annonces
        function getFilteredVehicles(prixValue,anneeValue,kmValue) {
            const cards = document.querySelectorAll('.carCard');
            cards.forEach(card => {
                const cardPrix =  parseInt(card.querySelector('.prix').innerText.replace(' €', '').replace(/\s+/g, ''));
                const cardAnnee = parseInt(card.querySelector('.year').innerText);
                const cardKm = parseInt(card.querySelector('.km').innerText.replace(/\s+/g, ''));
                    console.log(cardPrix,cardAnnee,cardKm);
                if (cardPrix <= (prixValue)) {
                    if (cardAnnee <= (anneeValue) && cardKm <= (kmValue)) {
                      // Afficher la carte si elle correspond au critère de filtrage
                    card.style.display = 'block';
                } else {
                      // Masquer la carte si elle ne correspond pas au critère de filtrage
                    card.style.display = 'none';
                }
            };
        });
    }

    //afficher valeur sur range
        function afficherValeur(inputId, outputId) {
            const inputElement = document.getElementById(inputId);
            const outputElement = document.getElementById(outputId);
            outputElement.textContent = inputElement.value;
        }
    // fonction actionnant les filtres
        document.addEventListener("DOMContentLoaded", function () {
            afficherValeur("prix", "prixValeur");
            afficherValeur("annee", "anneeValeur");
            afficherValeur("km", "kmValeur");

            document.getElementById("prix").addEventListener("input", function () {    
                afficherValeur("prix", "prixValeur");
                getFilteredVehicles(parseInt(this.value), parseInt(document.getElementById("annee").value), parseInt(document.getElementById("km").value));
                console.log(parseInt(this.value),document.getElementById("annee").value,document.getElementById("km").value)
            });

            document.getElementById("annee").addEventListener("input", function () {
                afficherValeur("annee", "anneeValeur");
                getFilteredVehicles(parseInt(document.getElementById("prix").value), parseInt(this.value), parseInt(document.getElementById("km").value));
            });

            document.getElementById("km").addEventListener("input", function () {
                afficherValeur("km", "kmValeur");
                getFilteredVehicles(parseInt(document.getElementById("prix").value), parseInt(document.getElementById("annee").value), parseInt(this.value));
            });
        });
        