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
                $("#imagearticlecat" + id).attr('src', "http://localhost:8000/" + img);
                $("#lienArticle" + id).attr('href', "http://localhost:8000/actualité/" + data.slug)
                dateafiichage = new Date(data.dateArticle.date);
                // console.log( parseInt(dateafiichage.getDate())+"/"+parseInt((dateafiichage.getMonth() + 1))+ "/" + parseInt(dateafiichage.getFullYear()))
                toString(dateafiichage.getDate()+"/"+(dateafiichage.getMonth() + 1)+ "/" + dateafiichage.getFullYear())
                // $("#date" + id).html(parseInt(dateafiichage.getDate())+"/"+parseInt((dateafiichage.getMonth() + 1))+ "/" + parseInt(dateafiichage.getFullYear()))
                // $("#date" + id).html(dateafiichage.getDate() + "/" + (dateafiichage.getMonth() + 1) + "/" + dateafiichage.getFullYear())
                $("#date" + id).html(data.dateArticle.date)
                console.log(data.dateArticle.date)
                // console.log(dateafiichage.getDate()+"/"+(dateafiichage.getMonth() + 1)+ "/" + dateafiichage.getFullYear())
            }
        }
    )
}