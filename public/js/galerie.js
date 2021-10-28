function galerieAjax(value ) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'image': value,
            },
            success: function (data) {
                img = "/uploads/" + data.image;
                $("#imageCategory" +value).attr('src', "http://localhost:8000/" + img);
                // $("#imageCategory" +value).attr('src', "https://fce-merignac-arlac.fr/" + img);
                }
        })
}
