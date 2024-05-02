function editPortfolio() {
    // Enable all textareas in the portfolio
    var textareas = document.querySelectorAll('#portfolio textarea');
    for (var i = 0; i < textareas.length; i++) {
        textareas[i].disabled = false;
    }

    // Enable the save button and disable the edit button
    document.querySelector('.save-btn').disabled = false;
    document.querySelector('.edit-btn').disabled = true;
}

function savePortfolio() {
    // Enable all textareas in the portfolio
    var textareas = document.querySelectorAll('#portfolio textarea');
    for (var i = 0; i < textareas.length; i++) {
        textareas[i].disabled = false; // Textareas should be enabled before submitting the form
    }

    // Disable the save button and enable the edit button
    document.querySelector('.save-btn').disabled = true;
    document.querySelector('.edit-btn').disabled = false;

    // Submit the form
    document.querySelector('#portfolioForm').submit();

    return true; // Ensure the form gets submitted
}

function deletePortfolio() {
    if (confirm('Are you sure you want to delete your portfolio? This action cannot be undone.')) {
        // User clicked 'OK'
        window.location.href = 'deletePortfolio.php';
    }
}

window.onclick = function(event) {
    var modal = document.getElementById('confirmDeleteModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}