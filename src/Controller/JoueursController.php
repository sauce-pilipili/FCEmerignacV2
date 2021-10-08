<?php

namespace App\Controller;

use App\Entity\Joueurs;
use App\Entity\Photo;
use App\Form\JoueursType;
use App\Repository\JoueursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/joueurs")
 */
class JoueursController extends AbstractController
{
    /**
     * @Route("/", name="joueurs_index", methods={"GET"})
     */
    public function index(JoueursRepository $joueursRepository): Response
    {
        return $this->render('joueurs/index.html.twig', [
            'joueurs' => $joueursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="joueurs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $joueur = new Joueurs();
        $form = $this->createForm(JoueursType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
// photo debout
            $photoDebout = $form->get('photoDebout')->getData();
            $fichier = md5(uniqid()) . '.' . $photoDebout->guessExtension();
            $photoDebout->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            $photoDeboutresultat = new Photo();
            $photoDeboutresultat->setName($fichier);
            $joueur->setPhotoDebout($photoDeboutresultat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($joueur);
            //photo portrait


            $photoPortrait = $form->get('photoPortrait')->getData();
            $fichier = md5(uniqid()) . '.' . $photoPortrait->guessExtension();
            $photoPortrait->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $photoPortraitresultat = new Photo();
            $photoPortraitresultat->setName($fichier);
            $joueur->setPhotoPortrait($photoPortraitresultat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($joueur);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($joueur);
            $entityManager->flush();

            return $this->redirectToRoute('joueurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joueurs/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="joueurs_show", methods={"GET"})
     */
    public function show(Joueurs $joueur): Response
    {
        return $this->render('joueurs/show.html.twig', [
            'joueur' => $joueur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="joueurs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Joueurs $joueur): Response
    {
        $form = $this->createForm(JoueursType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($form->get('photoDebout')->getData() != null) {
//                dd($form->get('photoDebout')->getData());
                $photoDebout = $form->get('photoDebout')->getData();
                $fichier = md5(uniqid()) . '.' . $photoDebout->guessExtension();
                $photoDebout->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $photoDeboutresultat = new Photo();
                $photoDeboutresultat->setName($fichier);
                $joueur->setPhotoDebout($photoDeboutresultat);

                $entityManager->persist($joueur);

            }
            if ($form->get('photoPortrait')->getData() != null) {

                //photo portrait
                $photoPortrait = $form->get('photoPortrait')->getData();
                $fichier = md5(uniqid()) . '.' . $photoPortrait->guessExtension();
                $photoPortrait->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $photoPortraitresultat = new Photo();
                $photoPortraitresultat->setName($fichier);
                $joueur->setPhotoPortrait($photoPortraitresultat);

                $entityManager->persist($joueur);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('joueurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joueurs/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="joueurs_delete", methods={"POST"})
     */
    public function delete(Request $request, Joueurs $joueur): Response
    {
        if ($this->isCsrfTokenValid('delete' . $joueur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($joueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('joueurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
