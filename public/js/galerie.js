function galerieAjax(value ) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'image': value,
            },
            success: function (data) {
                console.log(data.image + value)
                img = "/uploads/" + data.image;
                $("#imageCategory" +value).attr('src', "https://backstages-test.fr/" + img);

                }


        })
}


