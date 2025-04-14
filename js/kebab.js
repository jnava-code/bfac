// Get the kebab menu icon and dropdown menu
const kebabMenu = document.getElementById("kebabMenu");
const dropdownMenu = document.getElementById("dropdownMenu");

// Toggle the visibility of the dropdown when the kebab menu is clicked
kebabMenu.addEventListener("click", function(event) {
    event.stopPropagation();  // Prevent the click from propagating to the document
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
});

// Close the dropdown if the user clicks outside of the menu
window.addEventListener("click", function(event) {
    if (!dropdownMenu.contains(event.target) && event.target !== kebabMenu) {
        dropdownMenu.style.display = "none";
    }
});
