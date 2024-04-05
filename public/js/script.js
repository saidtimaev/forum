// Boutons
var buttons = document.querySelectorAll(".myBtn");

// Pour chaque bouton
buttons.forEach(function(button) {
    // Ajout event listener
    button.addEventListener("click", function() {
        // Modal associé avec le bouton
        var modal = this.nextElementSibling;
        // Afficher le modal
        modal.style.display = "block";
    });
});

// Tous les boutons de fermeture du modal
var closeButtons = document.querySelectorAll(".close");

// Pour chaque bouton fermer
closeButtons.forEach(function(closeButton) {
    // Ajout event listener
    closeButton.addEventListener("click", function() {
        // Modal associé avec le bouton fermer
        var modal = this.parentNode.parentNode;
        // Cacher le modal
        modal.style.display = "none";
    });
});

// Quand l'utilisateur clique en dehors du modal, le fermer
window.onclick = function(event) {
    var modals = document.querySelectorAll(".modal");
    modals.forEach(function(modal) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
};