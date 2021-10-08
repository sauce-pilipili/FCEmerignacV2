<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Photo;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/index", name="articles_index", methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="articles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setCreatedDate(new \DateTime('now'));
//            gestion image de mise en avant
            $image = $form->get('photoEnAvant')->getData();
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $img = new Photo();
            $img->setName($fichier);
            $article->setPhotoEnAvant($img);
//            gestion des trois images du fond de page
            $imagedeFond = $form->get('photoDeFond')->getData();
            foreach ($imagedeFond as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Photo();
                $img->setName($fichier);
                $article->addPhotoFond($img);
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="articles_show", methods={"GET"})
     */
    public function show(Articles $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Articles $article, PhotoRepository $photoRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        $nom = $article->getPhotoEnAvant()->getName();
        if ($form->isSubmitted() && $form->isValid()) {

            //            gestion image de mise en avant
            if ($form->get('photoEnAvant')->getData() != null) {
                unlink($this->getParameter('images_directory') . '/' . $nom);
                $image = $form->get('photoEnAvant')->getData();
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Photo();
                $img->setName($fichier);
                $article->setPhotoEnAvant($img);
            }
            if ($form->get('photoDeFond')->getData() != null) {
//               gestion des trois images du fond de page
                $imagedeFond = $form->get('photoDeFond')->getData();
                foreach ($imagedeFond as $image) {
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
                    // On crée l'image dans la base de données
                    $img = new Photo();
                    $img->setName($fichier);
                    $article->addPhotoFond($img);
                }
            }







            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/articles/supprime/photo/{id}", name="articles_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Photo $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);
            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }



    /**
     * @Route("/{id}", name="articles_delete", methods={"POST"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            if ($article->getPhotoFond() != null) {

                foreach ($article->getPhotoFond() as $img) {
                    unlink($this->getParameter('images_directory') . '/' . $img->getName());
                    $article->removePhotoFond($img);
                }
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
