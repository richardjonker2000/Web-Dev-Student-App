jQuery(document).ready(function($) {
    $('.subject-submit').submit(function(event) {
        event.preventDefault(); // stopping submitting
        var data = $(this).serializeArray();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: data
        })
            .done(function(response) {
                if (response.data.success == true) {
                    alert("Wow you commented");
                }
            })
            .fail(function() {
                console.log("error");
            });

    });
});
