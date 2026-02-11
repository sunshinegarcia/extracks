
// CATEGORIES MODAL JS

// Get references to DOM elements
const modal = document.getElementById("modal");
const categoryInput = document.getElementById("categoryInput");
const categoryList = document.getElementById("categoryList");

// OPEN MODAL

function openModal() {
    modal.style.display = "flex";  // show overlay and modal
    categoryInput.value = "";       // clear previous input
    categoryInput.focus();          // focus the input field
}

// CLOSE MODAL

function closeModal() {
    modal.style.display = "none";   // hide modal overlay
}

// HIDE MODAL ON PAGE LOAD

document.addEventListener("DOMContentLoaded", function () {
    closeModal();
});
