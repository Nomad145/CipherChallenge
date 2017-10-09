$("form").submit(function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function (data) {
            $('#result-panel').html(data.plain_text);
        }
    });
});
