<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Newletters\Users;
use App\Form\NewsLettersUsersType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoryRepository;
use App\Repository\EquipeRepository;
use App\Repository\MatchAVenirRepository;
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
    public function index(Request $request,
                          MatchAVenirRepository $nextMatchRepository,
                          ArticlesRepository $articlesRepository,
                          CategoryRepository $categoryRepository): Response
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
        if ($form->isSubmitted()&& $form->isValid()) {

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
            $slug = $article->getSlug();
            $image = $article->getPhotoEnAvant()->getName();
            return new Jsonresponse([
                'nextmatch' => $prochainMatch,
                'titre' => $titre,
                'dateArticle' => $date,
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
    public function equipe($id,Request $request,EquipeRepository $equipeRepository, CategoryRepository $categoryRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $categoryAjax = $request->get('category');
        $equipe = $equipeRepository->findAllTeam($categoryAjax);
        return new Jsonresponse([
            'equipe' => $equipe,
        ]);}

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
        if ($id == 'autres'){
            $equipe = $equipeRepository->findAllTeam();
            return $this->render('main/autresEquipe.html.twig', [
                'equipe'=> $equipe,
                'category'=>$category,
                'form' => $form->createView()
            ]);
        }

        $cattocompare = $categoryRepository->findAllCategory();
        if ($this->compare($id, $cattocompare)){

            $equipe = $equipeRepository->findotherTeam($id);
//            $equipe = $categoryRepository->findTeamInCategory($id);

            return $this->render('main/autresEquipe.html.twig', [
                'equipe'=> $equipe,
                'category'=>$category,
                'form' => $form->createView()
            ]);

        }
        else{
            $equipe = $equipeRepository->findEquipe($id);
        }
        return $this->render('main/equipe.html.twig', [
            'equipe'=> $equipe,
            'form' => $form->createView()
        ]);
    }

    public function compare($id,  $cattocompare){
        foreach ($cattocompare as $cat){
            if($id == $cat){
                return true;
            }
        }

    }

    /**
     * @Route("/equipe/fille", name="equipe_fille")
     */
    public function equipeF(Request $request): Response
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
        return $this->render('main/equipe.html.twig', [
            'form' => $form->createView()
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
     * @Route("actualité/{slug}", options={"expose"=true},name="article_slug")
     */
    public function article(Request $request,$slug)
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
}
