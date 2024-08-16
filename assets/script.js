        function afficherValeur(inputId, outputId) {
            const inputElement = document.getElementById(inputId);
            const outputElement = document.getElementById(outputId);
            outputElement.textContent = inputElement.value;
        }
         //**Fonction appelée lors de la modification du curseur de prix
        function updatePrixValue() {
    // Récupérer la valeur du curseur de prix
        var prixValue = document.getElementById('prix').value;
    // Mettre à jour le contenu de l'élément span avec la valeur du curseur
        document.getElementById('prixValeur').innerText = prixValue + ' €';
        }
        function getFilteredVehicles(prixValue,anneeValue,kmValue) {
            const cards = document.querySelectorAll('.carCard');
            cards.forEach(card => {
                const cardPrix =  parseInt(card.querySelector('.prix').innerText);
                console.log(cardPrix);
                const cardAnnee = parseInt(card.querySelector('.annee').innerText);
                const cardKm = parseInt(card.querySelector('.km').innerText);

                if (cardPrix <= (prixValue+1)) {
                    if (cardAnnee <= (anneeValue+1) && cardKm <= (kmValue+1)) {
                      // Afficher la carte si elle correspond au critère de filtrage
                    card.style.display = 'block';
                } else {
                      // Masquer la carte si elle ne correspond pas au critère de filtrage
                    card.style.display = 'none';
                }
            };
        });
    }

        document.addEventListener("DOMContentLoaded", function () {
            afficherValeur("prix", "prixValeur");
            afficherValeur("annee", "anneeValeur");
            afficherValeur("km", "kmValeur");

            document.getElementById("prix").addEventListener("input", function () {    
                afficherValeur("prix", "prixValeur");
                getFilteredVehicles(parseInt(this.value), parseInt(document.getElementById("annee").value), parseInt(document.getElementById("km").value));
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
