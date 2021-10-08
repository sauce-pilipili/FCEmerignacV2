<?php

namespace App\Controller;

use App\Entity\MatchAVenir;
use App\Form\MatchAVenirType;
use App\Repository\MatchAVenirRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/match/a/venir")
 */
class MatchAVenirController extends AbstractController
{
    /**
     * @Route("/", name="match_a_venir_index", methods={"GET"})
     */
    public function index(MatchAVenirRepository $matchAVenirRepository): Response
    {
        return $this->render('match_a_venir/index.html.twig', [
            'next_matches' => $matchAVenirRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="match_a_venir_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $matchAVenir = new MatchAVenir();
        $form = $this->createForm(MatchAVenirType::class, $matchAVenir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matchAVenir);
            $entityManager->flush();

            return $this->redirectToRoute('match_a_venir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('match_a_venir/new.html.twig', [
            'next_matches' => $matchAVenir,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="match_a_venir_show", methods={"GET"})
     */
    public function show(MatchAVenir $matchAVenir): Response
    {
        return $this->render('match_a_venir/show.html.twig', [
            'next_matches' => $matchAVenir,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="match_a_venir_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MatchAVenir $matchAVenir): Response
    {
        $form = $this->createForm(MatchAVenirType::class, $matchAVenir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('match_a_venir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('match_a_venir/edit.html.twig', [
            'next_matches' => $matchAVenir,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="match_a_venir_delete", methods={"POST"})
     */
    public function delete(Request $request, MatchAVenir $matchAVenir): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matchAVenir->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($matchAVenir);
            $entityManager->flush();
        }

        return $this->redirectToRoute('match_a_venir_index', [], Response::HTTP_SEE_OTHER);
    }
}
