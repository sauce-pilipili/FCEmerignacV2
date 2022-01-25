<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Joueurs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request): Response
    {
        // Nous récupérons le nom d'hôte depuis l'URL
        $hostname = $request->getSchemeAndHttpHost();

        // On initialise un tableau pour lister les URLs
        $urls = [];

// On ajoute les URLs "statiques"
        $urls[] = ['loc' => $this->generateUrl('accueil')];
        $urls[] = ['loc' => $this->generateUrl('main_equipe',['id'=>'Séniors Elite Masculin'])];
        $urls[] = ['loc' => $this->generateUrl('main_equipe',['id'=>'Séniors Elite Feminine'])];
        $urls[] = ['loc' => $this->generateUrl('main_equipe',['id'=>'autres'])];
        $urls[] = ['loc' => $this->generateUrl('galerie')];
        $urls[] = ['loc' => $this->generateUrl('about')];
        $urls[] = ['loc' => $this->generateUrl('mention_legal')];
        $urls[] = ['loc' => $this->generateUrl('histoire')];
        $urls[] = ['loc' => $this->generateUrl('organisation')];
        $urls[] = ['loc' => $this->generateUrl('stade')];
        $urls[] = ['loc' => $this->generateUrl('contact')];

// On ajoute les URLs dynamiques des articles dans le tableau
        foreach ($this->getDoctrine()->getRepository(Articles::class)->findAll() as $article) {
            $images = [
                'loc' => '/uploads/' . $article->getPhotoEnAvant(), // URL to image
                'title' => $article->getTitre()    // Optional, text describing the image
            ];
            $urls[] = [
                'loc' => $this->generateUrl('article_slug', [
                    'slug' => $article->getSlug(),
                ]),
                'lastmod' => $article->getCreatedDate()->format('Y-m-d'),
                'image' => $images
            ];
        }

        foreach ($this->getDoctrine()->getRepository(Joueurs::class)->findAll() as $joueur) {
            $images = [
                'loc' => '/uploads/' . $joueur->getPhotoPortrait(), // URL to image
                'title' => $joueur->getName().' '.$joueur->getLastname()    // Optional, text describing the image
            ];
            $urls[] = [
                'loc' => $this->generateUrl('main_joueur', [
                    'id' => $joueur->getId(),
                ]),
                'image' => $images
            ];
        }








        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

// Ajout des entêtes
        $response->headers->set('Content-Type', 'text/xml');

// On envoie la réponse
        return $response;
    }


}
