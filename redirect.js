document.getElementById('submit-btn').addEventListener('click', function() {
    var scheme = document.getElementById('scheme').value;
    var semester = document.getElementById('semester').value;
    // Redirect to the second page with query parameters
    window.location.href = 'obe.html?scheme=' + scheme + '&semester=' + semester;
});