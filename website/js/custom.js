$(function() {
    $('#results-list').hide();
    $('#search-creds').click(function() {
        doSearch();
    });
    $('#last-name').keydown(function(e) {
        if (e.keyCode == 13) {
            doSearch();
        }
    });
});

function doSearch() {
    var firstName = $('#first-name').val();
    var lastName = $('#last-name').val();
    $('#results-list').hide();
    $.ajax({
        url: 'includes/search_credentials.php',
        type: 'POST',
        data: {
            'first-name': firstName,
            'last-name': lastName
        },
        success: function(data) {
            if (data.success) {
                $('#results-list').empty();
                if (data.results.length > 0) {
                    $.each(data.results, function() {
                        $('#results-list').append("<li>" + this.first_name + " " + this.last_name + "</li>");
                    });
                }
                else {
                    $('#results-list').append("Your search did not return any results");
                }
                $('#results-list').fadeIn();
            }
            else {
                alert(data.error);
            }
        }
    });
}
