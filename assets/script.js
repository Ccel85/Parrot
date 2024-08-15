        function afficherValeur(inputId, outputId) {
            const inputElement = document.getElementById(inputId);
            const outputElement = document.getElementById(outputId);
            outputElement.textContent = inputElement.value;
        }

        function getFilteredVehicles(prix, annee, km) {
            const cards = document.querySelectorAll('.carCard');
            cards.forEach(card => {
                const cardPrix = parseInt(card.getAttribute('data-prix'));
                const cardAnnee = parseInt(card.getAttribute('data-annee'));
                const cardKm = parseInt(card.getAttribute('data-km'));

                if (cardPrix <= prix | cardAnnee <= annee | cardKm <= km) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
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
