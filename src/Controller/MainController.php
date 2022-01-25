<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Newletters\Users;
use App\Form\CategoryGaleryType;
use App\Form\NewsLettersUsersType;
use App\Repository\AlbumsRepository;
use App\Repository\ArticlesRepository;
use App\Repository\CategoryRepository;
use App\Repository\EquipeRepository;
use App\Repository\GaleryRepository;
use App\Repository\JoueursRepository;
use App\Repository\MatchAVenirRepository;
use App\Repository\SubGaleryRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="accueil", methods={"POST","GET"})
     */
    public function index(Request               $request,
                          MatchAVenirRepository $nextMatchRepository,
                          ArticlesRepository    $articlesRepository,
                          CategoryRepository    $categoryRepository): Response
    {
        // le dernier article publié
        $articlePremier = $articlesRepository->findLast();
        // la liste des match a venir
        $prochainMatch = $nextMatchRepository->findAllMatchToPlay();

        // les categories qui ont des articles
//        $categoryArticles = $categoryRepository->findAllCategory();
        $categoryArticles = $categoryRepository->findAllCategoryWithArticles();

        //les articles des info-club
        $articleInfoDuClub = $articlesRepository->findByCategoryInfoClub('Info-Club');
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $user->setIsValid(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('accueil');
        }

        if ($request->isXmlHttpRequest()) {
//            recup de la catégorie
            $categoryAjax = $request->get('category');
            // reponse ajax de l'article dans la catégories affichée
            $article = $articlesRepository->findByCategory($categoryAjax);
            $titre = $article->getTitre();
            $date = $article->getCreatedDate();
            $date =
            $date = date_format($article->getCreatedDate(),'Y-m-d');
            $datestring = explode('-',$date);
//            $date = $article->getCreatedDate()->date_format('m-d-Y H:s');
            $slug = $article->getSlug();
            $image = $article->getPhotoEnAvant()->getName();
            return new Jsonresponse([
                'nextmatch' => $prochainMatch,
                'titre' => $titre,
                'annee' => $datestring[0],
                'mois'=>$datestring[1],
                'jour'=>$datestring[2],
                'slug' => $slug,
                'image' => $image,

            ]);
        }

        return $this->render('main/index.html.twig', [
            'articlePremier' => $articlePremier,
            'articleInfo' => $articleInfoDuClub,
            'category' => $categoryArticles,
            'nextmatch' => $prochainMatch,
            'form' => $form->createView()

        ]);
    }


    /**
     * @Route("/equipe/{id}", name="main_equipe")
     */
    public function equipe($id, Request $request, EquipeRepository $equipeRepository, CategoryRepository $categoryRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $categoryAjax = $request->get('category');
            $equipe = $equipeRepository->findAllTeam($categoryAjax);
            return new Jsonresponse([
                'equipe' => $equipe,
            ]);
        }

        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }


        $category = $categoryRepository->findAllCategory();
        if ($id == 'autres') {
            $equipe = $equipeRepository->findAllTeam();
            return $this->render('main/autresEquipe.html.twig', [
                'equipe' => $equipe,
                'category' => $category,
                'form' => $form->createView()
            ]);
        }

        $cattocompare = $categoryRepository->findAllCategory();
        if ($this->compare($id, $cattocompare)) {

            $equipe = $equipeRepository->findotherTeam($id);

            return $this->render('main/autresEquipe.html.twig', [
                'equipe' => $equipe,
                'category' => $category,
                'form' => $form->createView()
            ]);
        } else {
            $equipe = $equipeRepository->findEquipe($id);
        }
        return $this->render('main/equipe.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView()
        ]);
    }
    public function compare($id, $cattocompare)
    {
        foreach ($cattocompare as $cat) {
            if ($id == $cat) {
                return true;
            }
        }
    }

    /**
     * @Route("/joueur/{id}", name="main_joueur")
     */
    public function joueurView(Request $request,$id, JoueursRepository $joueursRepository){
        $joueur = $joueursRepository->find($id);
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/joueur.html.twig',[
            'joueur'=>$joueur,
            'form'=>$form->createView()
        ]);

    }


    /**
     * @Route("/main/albums/view{id}", name="main_albums_view")
     */
    public function albumsView($id, Request $request, AlbumsRepository $albumsRepository): Response
    {
        $albums = $albumsRepository->find($id);

        if ($request->isXmlHttpRequest()) {
            $imageHasard = $albumsRepository->findAPhoto($request->get('image'));
            $image = $imageHasard['name'];
            return new Jsonresponse([
                'image' => $image,
            ]);
        }

        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/albumsView.html.twig', [
            'form' => $form->createView(),
            'albums' => $albums,
        ]);
    }

    /**
     * @Route("/main/albums{id}", name="main_albums")
     */
    public function albums($id, Request $request, AlbumsRepository $albumsRepository): Response
    {
        $albums = $albumsRepository->findMainAlbumParSousCategory($id);

        if ($request->isXmlHttpRequest()) {
            $imageHasard = $albumsRepository->findAPhoto($request->get('image'));
            $image = $imageHasard['name'];
            return new Jsonresponse([
                'image' => $image,
            ]);
        }

        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/albums.html.twig', [
            'form' => $form->createView(),
            'albums' => $albums,
        ]);
    }

    /**
     * @Route("/sous/galerie{id}", name="sous_galerie")
     */
    public function subGalery($id, Request $request, SubGaleryRepository $subGaleryRepository): Response
    {
        $sousGalery = $subGaleryRepository->findMainSousGalerieParCategory($id);

        if ($request->isXmlHttpRequest()) {
            $imageHasard = $subGaleryRepository->findAPhoto($request->get('image'));
            $image = $imageHasard['name'];
            return new Jsonresponse([
                'image' => $image,
            ]);
        }

        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/subGalery.html.twig', [
            'form' => $form->createView(),
            'subGalery' => $sousGalery,
        ]);
    }


    /**
     * @Route("/galerie", name="galerie")
     */
    public function Galery(Request $request, GaleryRepository $galeryRepository, SubGaleryRepository $subGaleryRepository): Response
    {
        $galerie = $galeryRepository->findByExampleField();

        if ($request->isXmlHttpRequest()) {
            $imageHasard = $galeryRepository->findAPhoto($request->get('image'));
            $image = $imageHasard['name'];
            return new Jsonresponse([
                'image' => $image,
            ]);
        }
        $catForm = $this->createForm(CategoryGaleryType::class);
        $catForm->handleRequest($request);

        if ($catForm->isSubmitted()&& $catForm->isValid()){
            $galerie = $galeryRepository->find($catForm->get('name')->getData());
            return $this->redirectToRoute('sous_galerie',['id'=>$galerie->getId()]);
        }

        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/galerie.html.twig', [
            'catForm'=>$catForm->createView(),
            'form' => $form->createView(),
            'galerie' => $galerie,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(Request $request): Response
    {

        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/about.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mention/legal", name="mention_legal")
     */
    public function legal(Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/legals.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("actualite/{slug}", options={"expose"=true},name="article_slug")
     */
    public function article(Request $request, $slug)
    {
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy(['slug' => $slug]);
        if (!$article) {
            throw $this->createNotFoundException("l'article n'existe pas");
        }
        return $this->render('main/actualite.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/histoire",name="histoire")
     */
    public function history(Request $request){
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/histoire.html.twig', [
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route("/organisation",name="organisation")
     */
    public function organisation(Request $request){
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/organisation.html.twig', [
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route("/stade",name="stade")
     */
    public function stade(Request $request){
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/stade.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/contact",name="contact")
     */
    public function contact(Request $request){
        $user = new Users();
        $form = $this->createForm(NewsLettersUsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setCreatedDate(new \DateTime('now'));
            $user->setValidationToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
