$(document).ready(function() {
    // Show default tab content
    $('#tab1').show();

    // Tab click event
    $('.tab').click(function() {
        // Hide all tab content
        $('.tab-content').hide();

        // Show the selected tab content
        var tabId = $(this).data('tab');
        $('#' + tabId).show();
    });
});