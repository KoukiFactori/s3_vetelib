// Récupère la balise <div> qui contient les images
var carousel = document.getElementById("carousel");

// Récupère les images contenues dans la balise <div>
var images = carousel.getElementsByTagName("img");

// Index de l'image à afficher
var index = 0;

// Fonction pour passer à l'image précédente
function previous() {
  // Masque l'image actuelle
  images[index].style.display = "none";

  // Décrémente l'index
  index = (index - 1 + images.length) % images.length;

  // Affiche l'image précédente
  images[index].style.display = "block";
}

// Fonction pour passer à l'image suivante
function next() {
  // Masque l'image actuelle
  images[index].style.display = "none";

  // Incrémente l'index
  index = (index + 1) % images.length;

  // Affiche l'image suivante
  images[index].style.display = "block";
}

// Définit une intervalle de temps pour passer à l'image suivante toutes les 3 secondes
setInterval(next, 3000);
