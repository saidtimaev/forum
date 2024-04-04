// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var p = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var btns = document.getElementsByClassName("close");

// When the user clicks on the button, open the modal
p.onclick = function() {
  modal.style.display = "block";
}

btns.forEach(btn => {
    btn.onclick = function() {
        modal.style.display = "none";
      }
});
// When the user clicks on <span> (x), close the modal


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}