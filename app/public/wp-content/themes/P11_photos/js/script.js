// Fonction pour gérer l'ouverture/fermeture du menu
function toggleNav() {
  const overlay = document.getElementById("myNav");
  const menuButton = document.getElementById("menuButton");
  const closeButton = document.querySelector(".Croixburger-menu");

  if (overlay.classList.contains("open")) {
    overlay.classList.remove("open");
    menuButton.classList.remove("hidden");
    closeButton.classList.add("hidden");
  } else {
    overlay.classList.add("open");
    menuButton.classList.add("hidden");
    closeButton.classList.remove("hidden");
  }
}

// Ajouter l'écouteur pour le scroll uniquement pour les ancres
document.querySelectorAll('.overlay a').forEach(anchor => {
 anchor.addEventListener('click', function (e) {
   const href = this.getAttribute('href');
  
   // Si c'est le lien "Contact"
   if (this.id === 'menu-item-39') {
     e.preventDefault(); // Empêche le comportement par défaut
     openModal(); // Ouvre la modale
     toggleNav(); // Ferme le menu après le clic
   } else if (href && href.startsWith('#')) {
     e.preventDefault(); // Empêche le comportement par défaut pour les ancres
     const target = document.querySelector(href);
     if (target) {
       target.scrollIntoView({ behavior: 'smooth' });
       toggleNav(); // Ferme le menu après le clic
     }
   } else {
     // Pour les liens externes, ferme simplement le menu après le clic
     toggleNav();
   }
 });
});




jQuery(document).ready(function ($) {
 var modal = $('#contactModal');
 var contactLink = $('#menu-item-39');
 var contactButton = $('#openContactModal'); // Bouton de single-photo pour ouvrir la modale


 // Ouverture de la modale depuis le lien de l'overlay
 contactLink.on('click', function (e) {
   e.preventDefault();
   e.stopPropagation();
   modal.css('display', 'flex'); // Affiche la modale
 });


 // Ouverture de la modale avec le champ ref.photo prérempli
 contactButton.on('click', function (e) {
   e.preventDefault();
   e.stopPropagation();
   var refPhoto = $(this).data('ref-photo');
   $("#contactModal .wpcf7-form .refphoto textarea").val(refPhoto); // Met à jour le champ "Réf.photo"
   modal.css('display', 'flex'); // Affiche la modale
 });


 // Ferme la modale si l'utilisateur clique en dehors
 $(window).on('click', function (e) {
   if ($(e.target).is(modal)) {
     modal.hide(); // Cache la modale
   }
 });
});


// Navigation entre les photos
jQuery(document).ready(function ($) {
  $('.navigation img').hover(function () {
    var thumbSrc = $(this).data('thumbnail');
    if (!$(this).next('.thumbnail-preview').length) {
      $(this).after('<img class="thumbnail-preview" src="' + thumbSrc + '" alt="Miniature">');
    }
    $(this).next('.thumbnail-preview').fadeIn(200);
  }, function () {
    $(this).next('.thumbnail-preview').fadeOut(200);
  });
});

// Pagination infinie avec requête AJAX
document.addEventListener('DOMContentLoaded', function () {
  const loadMoreBtn = document.getElementById('load-more');
  const photoListContainer = document.querySelector('.photo-list-container');
  let offset = 8; // On commence à 8 car les 8 premières photos sont déjà affichées

  loadMoreBtn.addEventListener('click', function () {
    fetch(ajax_params.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        action: 'load_more_photos',
        offset: offset,  // Envoie l'offset actuel
      })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          photoListContainer.insertAdjacentHTML('beforeend', data.data);
          offset += 8; // Incrémenter l'offset pour la prochaine requête
        } else {
          loadMoreBtn.textContent = 'Plus de photos disponibles';
          loadMoreBtn.disabled = true;
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
      });
  });
});

// Filtres
document.addEventListener('DOMContentLoaded', function () {
  const categoryButton = document.getElementById('category-button');
  const formatButton = document.getElementById('format-button');
  const sortButton = document.getElementById('sort-button');
  const categoryOptions = document.getElementById('category-options');
  const formatOptions = document.getElementById('format-options');
  const sortOptions = document.getElementById('sort-options');
  const photoListContainer = document.querySelector('.photo-list-container');

  // Sélection des icônes pour chaque bouton
  const iconDefaultCategory = categoryButton.querySelector(".icon-default");
  const iconDownCategory = categoryButton.querySelector(".icon-down");
  const iconDefaultFormat = formatButton.querySelector(".icon-default");
  const iconDownFormat = formatButton.querySelector(".icon-down");
  const iconDefaultSort = sortButton.querySelector(".icon-default");
  const iconDownSort = sortButton.querySelector(".icon-down");

  // Fonction pour ouvrir/fermer les options et basculer les icônes
  function toggleOptions(button, optionsElement, iconDefault, iconDown) {
      const isOpen = optionsElement.style.display === 'block';
      optionsElement.style.display = isOpen ? 'none' : 'block';

      // Basculer les icônes en fonction de l'état
      iconDefault.style.display = isOpen ? 'none' : 'inline';
      iconDown.style.display = isOpen ? 'inline' : 'none';
  }

  // Écouteurs pour ouvrir/fermer les dropdowns
  categoryButton.addEventListener('click', (event) => {
      event.stopPropagation();
      toggleOptions(categoryButton, categoryOptions, iconDefaultCategory, iconDownCategory);
  });

  formatButton.addEventListener('click', (event) => {
      event.stopPropagation();
      toggleOptions(formatButton, formatOptions, iconDefaultFormat, iconDownFormat);
  });

  sortButton.addEventListener('click', (event) => {
      event.stopPropagation();
      toggleOptions(sortButton, sortOptions, iconDefaultSort, iconDownSort);
  });

  // Fermer les dropdowns au clic en dehors
  document.addEventListener('click', () => {
      categoryOptions.style.display = 'none';
      formatOptions.style.display = 'none';
      sortOptions.style.display = 'none';
  });

  // Fonction de filtrage des photos
  function filterPhotos(category, format, order) {
      fetch(ajax_params.ajax_url, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
              action: 'filter_photos',
              category: category || '',
              format: format || '',
              order: order || ''
          })
      })
      .then(response => response.json())
      .then(data => {
          photoListContainer.innerHTML = data.success ? data.data : '<p>Aucune photo trouvée.</p>';
      })
      .catch(error => console.error('Erreur:', error));
  }

  // Écouteurs pour chaque option
  document.querySelectorAll('.dropdown-content .option').forEach(option => {
      option.addEventListener('click', function (event) {
          event.stopPropagation();

          const parentButton = option.closest('.dropdown').querySelector('.dropbtn');
          const value = option.dataset.value;

          if (option.classList.contains('reset-option')) {
              parentButton.textContent = parentButton === categoryButton ? 'CATEGORIE' : parentButton === formatButton ? 'FORMATS' : 'TRIER PAR';
              parentButton.removeAttribute('data-selected');
          } else {
              parentButton.textContent = option.textContent;
              parentButton.dataset.selected = value;
          }

          option.closest('.dropdown-content').style.display = 'none';

          // Lancer le filtrage
          filterPhotos(
              document.querySelector('#category-button').dataset.selected,
              document.querySelector('#format-button').dataset.selected,
              document.querySelector('#sort-button').dataset.selected
          );
      });
  });
});






// Lightbox 
document.addEventListener('DOMContentLoaded', function () {
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-photo');
  const lightboxClose = document.querySelector('.lightbox-close');
  const lightboxPrev = document.querySelector('.lightbox-prev');
  const lightboxNext = document.querySelector('.lightbox-next');
  const lightboxRef = document.querySelector('.lightbox-photo-ref');
  const lightboxCategory = document.querySelector('.lightbox-photo-category');
  let currentIndex = 0;
  let photos = [];

  function openLightbox(index) {
    currentIndex = index;
    const photo = photos[currentIndex];
    lightboxImg.src = photo.imgSrc;
    lightboxRef.textContent = 'Référence : ' + photo.ref;
    lightboxCategory.textContent = 'Catégorie : ' + photo.category;
    lightbox.style.display = 'flex';
  }

  function closeLightbox() {
    lightbox.style.display = 'none';
  }

  function prevPhoto() {
    if (currentIndex > 0) {
      currentIndex--;
      openLightbox(currentIndex);
    }
  }

  function nextPhoto() {
    if (currentIndex < photos.length - 1) {
      currentIndex++;
      openLightbox(currentIndex);
    }
  }

  lightboxClose.addEventListener('click', closeLightbox);
  lightboxPrev.addEventListener('click', prevPhoto);
  lightboxNext.addEventListener('click', nextPhoto);

  // Remplir le tableau de photos et ajouter les événements de clic pour chaque icône "icon-fullscreen"
  const photoBlocks = document.querySelectorAll('.related-photo'); // Remplace 'photo-item' par 'related-photo'
  photoBlocks.forEach((photoBlock, index) => {
    const img = photoBlock.querySelector('img'); // Cela prendra la première image dans le block
    const ref = photoBlock.dataset.ref; 
    const category = photoBlock.dataset.category; 
    const iconFullscreen = photoBlock.querySelector('.icon-fullscreen'); 

    // Si l'élément 'img' n'est pas celui du plein écran, on peut le spécifier en ajoutant un sélecteur plus précis
    const imgSrc = img.src; // Récupère la source de l'image principale, celle qui est à l'intérieur de <a>

    photos.push({
      imgSrc: imgSrc,
      ref: ref,
      category: category
    });

    // Ouvre la lightbox au clic sur l'icône "icon-fullscreen"
    iconFullscreen.addEventListener('click', (event) => {
      event.stopPropagation(); // Empêche la propagation du clic
      openLightbox(index); // Ouvre la lightbox pour l'index correspondant
    });
  });
});

// Affichage de la modale de contact
const contactModal = document.getElementById('contactModal');
document.querySelectorAll('.wpcf7-form input[type="text"], .wpcf7-form input[type="email"]').forEach(input => {
  input.addEventListener('focus', function() {
    contactModal.style.display = 'flex'; // Affiche la modale
  });
});

// Gestion du formulaire
document.addEventListener('submit', function (e) {
  e.preventDefault(); // Empêche l'envoi par défaut du formulaire

  // Logique pour gérer l'envoi du formulaire avec AJAX ici...
});
