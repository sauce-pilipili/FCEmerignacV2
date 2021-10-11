<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Photo;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe")
 */
class EquipeController extends AbstractController
{
    /**
     * @Route("/", name="equipe_index", methods={"GET"})
     */
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipeRepository->findAllTeam(),
        ]);
    }

    /**
     * @Route("/new", name="equipe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('images')->getData() != null) {
                $logo = $form->get('images')->getData();
                $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
                $logo->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $imgLogo = new Photo();
                $imgLogo->setName($fichier);
                $equipe->setPhotoEquipe($imgLogo);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("show/{id}", name="equipe_show", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipe $equipe): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('images')->getData() != null) {
                if ($equipe->getPhotoEquipe() != null) {
                    unlink($this->getParameter('images_directory') . '/' . $equipe->getPhotoEquipe()->getName());
                }
                    $logo = $form->get('images')->getData();
                    $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
                    $imgLogo = new photo();
                    $imgLogo->setName($fichier);
                    $equipe->setPhotoEquipe($imgLogo);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="equipe_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipe $equipe): Response
    {
        if ($this->isCsrfTokenValid('delete' . $equipe->getId(), $request->request->get('_token'))) {
            if ($equipe->getPhotoEquipe() != null) {
                unlink($this->getParameter('images_directory') . '/' . $equipe->getPhotoEquipe()->getName());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipe->getPhotoEquipe());
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
