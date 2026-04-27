document.querySelectorAll('.carousel').forEach((carousel) => { // ça récupère chaque carrousel de la page.
    const container = carousel.querySelector('.derouler'); // ça récupère la partie qui va bouger.
    const nextBtn = carousel.querySelector('.suivant'); // ça récupère le bouton suivant.
    const prevBtn = carousel.querySelector('.avant'); // ça récupère le bouton précédent.

    if (!container || !nextBtn || !prevBtn) { // si il manque un élément du carrousel.
        return; // ça arrête pour éviter une erreur.
    }

    let index = 0; // ça garde la position actuelle du carrousel.

    const getStep = () => { // c'est une fonction qui calcule de combien on doit avancer.
        const firstCard = container.querySelector('.tourner'); // ça prend la première carte.
        if (!firstCard) { // si il n'y a pas de carte.
            return 0; // ça renvoie 0.
        }

        const gap = parseFloat(getComputedStyle(container).gap) || 0; // ça récupère l'espace entre les cartes.
        return firstCard.getBoundingClientRect().width + gap; // ça renvoie la taille d'une carte avec l'espace.
    };

    const getMaxIndex = () => { // fonction qui calcule la dernière position possible.
        const step = getStep(); // ça récupère la taille d'un déplacement.
        const visibleWidth = carousel.querySelector('.fenetre-carousel').clientWidth; // largeur visible du carrousel.
        const totalWidth = container.scrollWidth; // largeur totale de toutes les cartes.

        if (!step || totalWidth <= visibleWidth) { // si rien ne peut défiler.
            return 0; // la position max reste 0.
        }

        return Math.ceil((totalWidth - visibleWidth) / step); // ça calcule combien de fois on peut avancer.
    };

    const updateCarousel = () => { // c'est une fonction qui met à jour le carrousel.
        const maxIndex = getMaxIndex(); // ça récupère la limite du carrousel.
        index = Math.min(index, maxIndex); // ça évite de dépasser la limite.

        container.style.transform = `translateX(-${index * getStep()}px)`; // ça déplace les cartes vers la gauche.
        prevBtn.disabled = index === 0; // ça désactive précédent si on est au début.
        nextBtn.disabled = index === maxIndex; // ça désactive suivant si on est à la fin.
    };

    nextBtn.addEventListener('click', () => { // quand on clique sur suivant.
        if (index < getMaxIndex()) { // si on n'est pas à la fin.
            index++; // ça avance d'une position.
            updateCarousel(); // met à jour l'affichage.
        }
    });

    prevBtn.addEventListener('click', () => { // quand on clique sur précédent.
        if (index > 0) { // si on n'est pas au début.
            index--; // ça recule d'une position.
            updateCarousel(); // ça met à jour l'affichage.
        }
    });

    window.addEventListener('resize', updateCarousel); // ça remet bien le carrousel si la taille de l'écran change.
    updateCarousel(); // c'est une fonction qui lance une première mise à jour.
});

const searchForm = document.querySelector('.haut-centre'); // ça récupère le formulaire de recherche.
const searchInput = document.querySelector('#searchInput'); // ça récupère la barre de recherche.
const films = document.querySelectorAll('.film-card'); // ça récupère toutes les cartes de films.

function searchFunction() { // fonction pour chercher un film.
    const recherche = searchInput.value.trim().toLowerCase(); // récupère le texte tapé en minuscule.

    films.forEach((film) => { // boucle sur chaque film.
        const titre = film.dataset.title || ''; // récupère le titre du film.
        film.classList.toggle('film-cache', recherche !== '' && !titre.includes(recherche)); // cache le film si il ne correspond pas.
    });
}

if (searchForm && searchInput) { // si la recherche existe sur la page.
    searchForm.addEventListener('submit', (event) => { // quand on valide la recherche.
        event.preventDefault(); // empêche la page de se recharger.
        searchFunction(); // lance la recherche.
    });

    searchInput.addEventListener('input', searchFunction); // lance la recherche pendant qu'on écrit.
}
