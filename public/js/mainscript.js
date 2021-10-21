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
                $("#titre" + id).html(data.titre)
                $("#imagearticlecat" + id).attr('src', "http://localhost:8000" + img);
                $("#lienArticle" + id).attr('href', "http://localhost:8000/actualite/" + data.slug)

                // $("#imagearticlecat" + id).attr('src', "https://www.backstages-test.fr" + img);
                // $("#lienArticle" + id).attr('href', "https://www.backstages-test.fr/actualite/" + data.slug)

                $("#date" + id).html(data.jour + " / " + data.mois + " / " + data.annee)

            }
        }
    )
}