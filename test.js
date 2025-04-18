
/**************************************** SLIDER ****************************************/

document.addEventListener('DOMContentLoaded', function () {
    // Fonction pour animer un slider donné
    function setupSlider(figureSelector) {
        const figure = document.querySelector(figureSelector);
        if (!figure) return;

        const slides = figure.children.length;
        let current = 0;

        setInterval(() => {
            current = (current + 1) % slides;
            figure.style.left = `-${current * 100}%`;
        }, 5000);
    }

    // Appliquer aux deux sliders
    setupSlider('#brise1');
    setupSlider('#brise2');
});




/**************************************** MODE CLAIR/SOMBRE ****************************************/


// Sélectionne le bouton
const toggleBtn = document.getElementById("toggle-dark-mode");

// Vérifie si un thème est déjà sauvegardé
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
    toggleBtn.textContent = "☀️ Mode clair";
}

// Au clic, bascule entre clair/sombre
toggleBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    // Met à jour le texte du bouton
    if (document.body.classList.contains("dark-mode")) {
        toggleBtn.textContent = "☀️ Mode clair";
        localStorage.setItem("theme", "dark");
    } else {
        toggleBtn.textContent = "🌙 Mode sombre";
        localStorage.setItem("theme", "light");
    }
});





/**************************************** DATE ACTUEL ****************************************/


    function afficherDateHeure() {
        const maintenant = new Date();

        const optionsDate = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        const dateFormatee = maintenant.toLocaleDateString('fr-FR', optionsDate);

        // Heure au format 24h avec 2 chiffres
        const heures = maintenant.getHours().toString().padStart(2, '0');
        const minutes = maintenant.getMinutes().toString().padStart(2, '0');
        const secondes = maintenant.getSeconds().toString().padStart(2, '0');

        const heureFormatee = `${heures}h${minutes}:${secondes}`;

        document.getElementById("date-heure-actuelle").textContent =
            `${dateFormatee}, ${heureFormatee}.`;
    }

    // Appel initial
    afficherDateHeure();

    // Mise à jour toutes les secondes
    setInterval(afficherDateHeure, 1000);




/**************************************** BOUTON RETOUR HAUT DE PAGE ****************************************/

const btnHaut = document.getElementById("btn-haut");

    window.onscroll = function () {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            btnHaut.style.display = "block";
        } else {
            btnHaut.style.display = "none";
        }
    };

    btnHaut.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });