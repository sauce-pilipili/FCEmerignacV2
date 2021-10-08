<?php

namespace App\Controller;

use App\Entity\Adversaires;
use App\Entity\Photo;
use App\Form\AdversairesType;
use App\Repository\AdversairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adversaires")
 */
class AdversairesController extends AbstractController
{
    /**
     * @Route("/", name="adversaires_index", methods={"GET"})
     */
    public function index(AdversairesRepository $adversairesRepository): Response
    {
        return $this->render('adversaires/index.html.twig', [
            'adversaires' => $adversairesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="adversaires_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $adversaire = new Adversaires();
        $form = $this->createForm(AdversairesType::class, $adversaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //enrigistrer le logo de l'equipe

            $logo = $form->get('logo')->getData();
            $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
            $logo->move(
                $this->getParameter('images_logo'),
                $fichier
            );

            $imgLogo = new Photo();
            $imgLogo->setName($fichier);
            $adversaire->setLogo($imgLogo);


            //sauvegarder
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adversaire);
            $entityManager->flush();

            return $this->redirectToRoute('adversaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adversaires/new.html.twig', [
            'adversaire' => $adversaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="adversaires_show", methods={"GET"})
     */
    public function show(Adversaires $adversaire): Response
    {
        return $this->render('adversaires/show.html.twig', [
            'adversaire' => $adversaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adversaires_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Adversaires $adversaire): Response
    {
        $form = $this->createForm(AdversairesType::class, $adversaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //enregistrer le logo si changement
            if ($form->get('logo')->getData() != null) {
                unlink($this->getParameter('images_logo') . '/' . $adversaire->getLogo()->getName());
                $logo = $form->get('logo')->getData();
                $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
                $logo->move(
                    $this->getParameter('images_logo'),
                    $fichier
                );
                $imgLogo = new photo();
                $imgLogo->setName($fichier);
                $adversaire->setLogo($imgLogo);
            }



            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adversaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adversaires/edit.html.twig', [
            'adversaire' => $adversaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="adversaires_delete", methods={"POST"})
     */
    public function delete(Request $request, Adversaires $adversaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adversaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adversaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adversaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
