// Open the modal for adding a new list
const addListBtn = document.getElementById("addListBtn");
const addListModal = document.getElementById("addListModal");

addListBtn.onclick = function() {
  addListModal.style.display = "block";
}

// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
  if (event.target == addListModal) {
    addListModal.style.display = "none";
  }
}

// Function to submit the form using AJAX
function submitForm() {
  const form = document.getElementById("addListForm");
  const formData = new FormData(form);

  // Send the form data using AJAX
  $.ajax({
    url: "add_list.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      // If successful, reload the page to show the updated list table
      location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      // Handle errors and show appropriate messages to the user
      console.error("AJAX Error: " + errorThrown);
      alert("Error occurred while creating the list.");
    }
  });

  // Close the modal after form submission
  addListModal.style.display = "none";
}
