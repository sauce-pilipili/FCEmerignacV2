function ArticleCategory(category, id) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'category': category,
            },
            success: function (data) {
                img = "/uploads/" + data.image;
                href = "{" + "{ path('article_slug','slug':" + data.slug + ") | urlFromJs }}"


                //ok en dessous

                $("#titre" + id).html(data.titre)
                $("#imagearticlecat" + id).attr('src', "https://fce-merignac-arlac.fr/" + img);
                $("#lienArticle" + id).attr('href', "https://fce-merignac-arlac.fr/actualité/" + data.slug)
                dateafiichage = new Date(data.dateArticle.date);
                $("#date" + id).html(dateafiichage.getDate() + "/" + (dateafiichage.getMonth() + 1) + "/" + dateafiichage.getFullYear())
                // fin de ok


            }
        }
    )
}
