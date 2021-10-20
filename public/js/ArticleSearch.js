function AjaxSearch(text) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'text': text,
            },
            success: function (data) {
                 $("#bodylist").html(data.content);
            }
        }
    )
}