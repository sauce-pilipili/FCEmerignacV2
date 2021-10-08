const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
function ArticleCategory(category, id) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'category': category,
            },
            success: function (data) {
                const slug = data.slug
                console.log(data.titre)
                console.log(data.image)
                console.log(data.dateArticle)

                var img = "/uploads/"+data.image;
                var href = "{"+"{ path('article_slug','slug':"+data.slug +") }}"
                $("#titre"+id).html(data.titre)
                $("#imagearticlecat"+id).attr('src', "http://localhost:8000"+img);

                var dateafiichage = new Date(data.dateArticle.date);
                $("#date"+id).html(dateafiichage.getDate()+"/"+ (dateafiichage.getMonth()+1) +"/"+dateafiichage.getFullYear())

                var url = Routing.generate('article_slug', data.slug );
                console.log(url)
                $("#lienArticle"+id).attr('href', url)

            }
        }
    )
}